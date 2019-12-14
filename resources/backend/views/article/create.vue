<template>
    <div class="app-container">
        <el-form ref="form" :model="item" label-width="80px">
            <el-row>
                <el-col :span="18">
                    <el-form-item label="标题">
                        <el-input v-model="item.title"></el-input>
                    </el-form-item>

                    <el-form-item label="别名">
                        <el-input v-model="item.alias"></el-input>
                    </el-form-item>

                    <el-form-item label="标签">
                        <el-tag
                            :key="tag"
                            v-for="tag in item.tags"
                            closable
                            :disable-transitions="false"
                            @close="handleClose(tag)">
                            {{tag}}
                        </el-tag>
                        <el-input
                            class="input-new-tag"
                            v-if="inputVisible"
                            v-model="inputValue"
                            ref="saveTagInput"
                            size="small"
                            @keyup.enter.native="handleInputConfirm"
                            @blur="handleInputConfirm"
                        >
                        </el-input>
                        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
                    </el-form-item>

                    <el-form-item label="内容">
                        <editor :height="300" v-model="item.content" id='tinymce'></editor>
                    </el-form-item>

                    <el-form-item label="下载地址">
                        <div v-if="item.files">
                            <file v-for="(file,index) in item.files" :item="file" :index="index" :key="index" @delete="onFileDelete" @upload="uploadFile"/>
                        </div>
                        <div v-else-if="item.files">没有附件</div>
                        <div v-else>附件加载中...</div>
                        <button @click="addFile">添加附件</button>
                    </el-form-item>

                </el-col>
                <el-col :span="6">
                    <el-form-item label="分类">
                        <el-select
                            v-model="item.categorys"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="请选择文章分类">
                            <el-option
                                v-for="item in cateforyList"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="状态">
                        <template>
                            <el-radio v-model="item.status" label="0">停用</el-radio>
                            <el-radio v-model="item.status" label="1">启用</el-radio>
                        </template>
                    </el-form-item>

                    <el-form-item label="缩略图">
                        <el-upload
                            class="avatar-uploader"
                            action="/api/upload/file"
                            :show-file-list="false"
                            :on-success="handleAvatarSuccess"
                            :before-upload="beforeAvatarUpload">
                            <img v-if="item.thumbnail" :src="item.thumbnail" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                    <el-form-item >
                        <el-input v-model="item.thumbnail"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>

        </el-form>
        <div style="text-align:right;">
            <router-link to="/Article/List">
                <el-button type="danger">Cancel</el-button>
            </router-link>
            <el-button type="primary" @click="confirmSave">Confirm</el-button>
        </div>

    </div>
</template>

<script>
    import { addArticle,updateArticle,fetchArticle } from '@/api/article'
    import { getCategoryAllList } from '@/api/category'
    import File from '@/views/article/file'
    import Pagination from '@/components/Pagination'
    import { validImage } from '@/utils/validate'
    import Editor from '@/components/Tinymce'

    const defaultFields = {
        id: '',
        title: '',
        alias: '',
        content: '',
        thumbnail: '',
        type: '',
        status: '',
        categorys: [],
        tags: [],
        files: [],
        more: '',
    }

    export default {
        name: 'ArticleList',
        components: { Pagination,File,Editor },
        filters: {
            statusFilter(status) {
                const statusMap = {
                    published: 'success',
                    draft: 'info',
                    deleted: 'danger'
                }
                return statusMap[status]
            }
        },
        data() {
            return {
                item: {},
                total: 0,
                cateforyList: null,
                listLoading: true,
                dialogVisible: false,
                dialogType: 'new',
                inputVisible: false,
                inputValue: '',
                listQuery: {
                    page: 1,
                    limit: 20
                }
            }
        },
        created() {
            this.item = Object.assign({}, defaultFields)
            this.item.id = this.$route.query.article_id;
            if(this.item.id > 1){
                document.title = '编辑'
                fetchArticle(this.item.id).then(response => {
                    this.item = response.data
                })
            }
            this.getCategoryAllList()
        },
        methods: {
            getCategoryAllList() {
                getCategoryAllList(this.listQuery).then(response => {
                    this.cateforyList = response.data.items
                })
            },
            handleClose(tag) {
                this.item.tags.splice(this.item.tags.indexOf(tag), 1);
            },
            showInput() {
                this.inputVisible = true;
                this.$nextTick(_ => {
                    this.$refs.saveTagInput.$refs.input.focus();
                });
            },
            handleInputConfirm() {
                let inputValue = this.inputValue;
                if (inputValue) {
                    console.log(this.item.tags.indexOf(inputValue))
                    if(this.item.tags.indexOf(inputValue) == -1){
                        this.item.tags.push(inputValue);
                    }else{
                        this.$message.error('[' + inputValue + ']标签已存在!');
                        return false;
                    }
                }
                this.inputVisible = false;
                this.inputValue = '';
            },
            uploadFile: function (val) {
                let index = val.index
                this.item.files[index] = val.data
                console.log('I got the data:', JSON.stringify(this.item.files))
            },
            onFileDelete(index) {
                this.item.files.splice(index,1)
            },
            addFile() {
                this.item.files.push({
                    name : "",
                    uri : ""
                });
            },
            async confirmSave() {

                if (this.item.id > 0) {
                    await updateArticle(this.item.id, this.item)
                } else {
                    const { data } = await addArticle(this.item)
                }

                const { title } = this.item

                this.$router.push({
                    path: '/Article/List'
                })

                this.$notify({
                    title: 'Success',
                    dangerouslyUseHTMLString: true,
                    message: `
                        <div>Nav Title: ${title}</div>
                      `,
                    type: 'success'
                })
            },
            handleAvatarSuccess(res, file) {
                this.item.thumbnail = res;
                // this.item.thumbnail = URL.createObjectURL(file.raw);
            },
            beforeAvatarUpload(file) {
                if(validImage(file)){
                    return true
                }else{
                    this.$message.error('请上传图片!');
                }
            },
            errorHandler() {
                return true
            }
        }
    }
</script>

<style scoped>
    .edit-input {
        padding-right: 100px;
    }
    .cancel-btn {
        position: absolute;
        right: 15px;
        top: 10px;
    }
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
    .el-tag + .el-tag {
        margin-left: 10px;
    }
    .button-new-tag {
        margin-left: 10px;
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }
</style>
