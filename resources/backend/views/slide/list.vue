<template>
    <div class="app-container">
        <el-row>
            <el-col :span="6">
                <el-button type="primary" @click="handleAdd">新建</el-button>
                <template>
                    <el-select v-model="search" placeholder="请选择">
                        <el-option
                            v-for="item in slideClassifyList"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </template>
            </el-col>
            <el-col :span="6">
            </el-col>
            <el-col :span="6">
            </el-col>
            <el-col :span="6">
            </el-col>
        </el-row>

        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="幻灯片标题">
                <template slot-scope="scope">
                    <span>{{ scope.row.title }}</span>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="幻灯片类型">
                <template slot-scope="scope">
                    <span>{{ scope.row.slide_id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="地址">
                <template slot-scope="scope">
                    <span>{{ scope.row.url }}</span>
                </template>
            </el-table-column>

            <el-table-column width="300px" align="center" label="描述">
                <template slot-scope="scope">
                    <span>{{ scope.row.description }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="内容">
                <template slot-scope="scope">
                    <span>{{ scope.row.content}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="状态">
                <template slot-scope="scope">
                    <span>{{ scope.row.status}}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="操作" width="200">
                <template slot-scope="scope">
                    <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEdit(scope)">
                        Edit
                    </el-button>
                    <el-button type="danger" size="small" @click="handleDelete(scope)">
                        Delete
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :visible.sync="dialogVisible" :title="dialogType==='edit'?'修改幻灯片':'创建幻灯片'">
            <el-form ref="form" :model="item" label-width="80px">

                <el-form-item label="标题">
                    <el-input v-model="item.title"></el-input>
                </el-form-item>

                <el-form-item label="图片">
                    <el-upload
                        class="avatar-uploader"
                        action="/api/upload/file"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                        <img v-if="item.image" :src="item.image" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                    <el-input v-model="item.image"></el-input>
                </el-form-item>

                <el-form-item label="分类">
                    <el-select v-model="item.slide_id" placeholder="请选择">
                        <el-option
                            v-for="item in slideClassifyList"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="描述">
                    <el-input v-model="item.description"></el-input>
                </el-form-item>

                <el-form-item label="地址">
                    <el-input v-model="item.url"></el-input>
                </el-form-item>

                <el-form-item label="内容">
                    <el-input v-model="item.content"></el-input>
                </el-form-item>

                <el-form-item label="状态">
                    <template>
                        <el-radio v-model="item.status" label="1">显示</el-radio>
                        <el-radio v-model="item.status" label="0">隐藏</el-radio>
                    </template>
                </el-form-item>

                <el-form-item label="排序">
                    <el-input v-model="item.list_order"></el-input>
                </el-form-item>

            </el-form>
            <div style="text-align:right;">
                <el-button type="danger" @click="dialogVisible=false">Cancel</el-button>
                <el-button type="primary" @click="confirmSlide">Confirm</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { fetchSlideList,addSlide,updateSlide,deleteSlide,getSlideClassifyAllList } from '@/api/slide'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'
    import { validImage } from '@/utils/validate'

    const defaultSlide = {
        id: '',
        slide_id: 0,
        title: '',
        description: '',
        content: '',
        image: '',
        status: '1',
        list_order: 10000
    }

    export default {
        name: 'SlideList',
        components: { Pagination },
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
                search: '',
                slideClassifyList: {},
                item: {},
                list: null,
                total: 0,
                listLoading: true,
                dialogVisible: false,
                dialogType: 'new',
                listQuery: {
                    page: 1,
                    limit: 20
                }
            }
        },
        created() {
            this.getList()
            this.getSlideClassifyList()
        },
        watch: {
            search(val,oldVal){
                console.log(val)
                fetchSlideList(this.listQuery,val).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            }
        },
        methods: {
            getList() {
                this.listLoading = true
                fetchSlideList(this.listQuery).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            getSlideClassifyList() {
                this.listLoading = true
                getSlideClassifyAllList().then(response => {
                    this.slideClassifyList = response.data.items
                })
            },
            handleAdd() {
                this.item = Object.assign({}, defaultSlide)
                this.dialogType = 'new'
                this.dialogVisible = true
            },
            handleEdit(scope) {
                this.dialogType = 'edit'
                this.dialogVisible = true
                this.item = deepClone(scope.row)
            },
            handleDelete({ $index, row }) {
                this.$confirm('Confirm to remove the Navigation?', 'Warning', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                })
                .then(async() => {
                    await deleteSlide(row.id)
                    this.list.splice($index, 1)
                    this.$message({
                        type: 'success',
                        message: 'Delete succed!'
                    })
                })
                .catch(err => { console.error(err) })
            },
            async confirmSlide() {
                const isEdit = this.dialogType === 'edit'

                if (isEdit) {
                    await updateSlide(this.item.id, this.item)
                    for (let index = 0; index < this.list.length; index++) {
                        if (this.list[index].id === this.item.id) {
                            this.list.splice(index, 1, Object.assign({}, this.item))
                            break
                        }
                    }
                } else {
                    const { data } = await addSlide(this.item)
                    this.item.id = data.id
                    this.list.push(this.item)
                }

                const { id, description, title } = this.item
                this.dialogVisible = false
                this.$notify({
                    title: 'Success',
                    dangerouslyUseHTMLString: true,
                    message: `
                        <div>Nav Name: ${title}</div>
                        <div>Nav Remark: ${description}</div>
                      `,
                    type: 'success'
                })
            },
            handleAvatarSuccess(res, file) {
                this.item.image = res;
                // this.item.avatar = URL.createObjectURL(file.raw);
            },
            beforeAvatarUpload(file) {
                if(validImage(file)){
                    return true
                }else{
                    this.$message.error('请上传图片!');
                }
            },
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
</style>
