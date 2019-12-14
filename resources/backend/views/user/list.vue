<template>
    <div class="app-container">
        <el-button type="primary" @click="handleAdd">新建</el-button>
        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="60px" align="center" label="头像">
                <template slot-scope="scope">
                    <el-avatar :src="scope.row.avatar"></el-avatar>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="名字">
                <template slot-scope="scope">
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>

            <el-table-column width="300px" align="center" label="账号">
                <template slot-scope="scope">
                    <span>{{ scope.row.account }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="手机号">
                <template slot-scope="scope">
                    <span>{{ scope.row.mobile}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="邮箱">
                <template slot-scope="scope">
                    <span>{{ scope.row.email}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="性别">
                <template slot-scope="scope">
                    <span>{{ scope.row.sex}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="生日">
                <template slot-scope="scope">
                    <span>{{ scope.row.birthday}}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="操作" width="200">
                <template slot-scope="scope">
                    <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEdit(scope)">
                        编辑
                    </el-button>
                    <el-button type="danger" size="small" @click="handleDelete(scope)">
                        删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :visible.sync="dialogVisible" :title="dialogType==='edit'?'编辑':'新建'">
            <el-form ref="form" :model="item" label-width="80px">

                <el-form-item label="名字">
                    <el-input v-model="item.name"></el-input>
                </el-form-item>

                <el-form-item label="账号">
                    <el-input v-model="item.account"></el-input>
                </el-form-item>

                <el-form-item label="手机号">
                    <el-input v-model="item.mobile"></el-input>
                </el-form-item>

                <el-form-item label="邮箱">
                    <el-input v-model="item.email"></el-input>
                </el-form-item>

                <el-form-item label="密码">
                    <el-input v-model="item.password"></el-input>
                </el-form-item>

                <el-form-item label="性别">
                    <template>
                        <el-radio v-model="item.sex" label="0">保密</el-radio>
                        <el-radio v-model="item.sex" label="1">男</el-radio>
                        <el-radio v-model="item.sex" label="2">女</el-radio>
                    </template>
                </el-form-item>

                <el-form-item label="生日">
                    <el-date-picker
                        v-model="item.birthday"
                        type="date"
                        placeholder="选择日期">
                    </el-date-picker>
                </el-form-item>

                <el-form-item label="状态">
                    <template>
                        <el-radio v-model="item.status" label="0">停用</el-radio>
                        <el-radio v-model="item.status" label="1">启用</el-radio>
                    </template>
                </el-form-item>

                <el-form-item label="头像">
                    <el-upload
                        class="avatar-uploader"
                        action="/api/upload/file"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                        <img v-if="item.avatar" :src="item.avatar" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>

            </el-form>
            <div style="text-align:right;">
                <el-button type="danger" @click="dialogVisible=false">Cancel</el-button>
                <el-button type="primary" @click="confirmUser">Confirm</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { fetchList,addUser,updateUser,deleteUser } from '@/api/user'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'
    import { validImage } from '@/utils/validate'

    const defaultUser = {
        id: '',
        name: '',
        account: '',
        mobile: '',
        email: '',
        password: '',
        sex: '0',
        birthday: '',
        status: '1',
        avatar: '',
    }

    export default {
        name: 'UserList',
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
        },
        methods: {
            getList() {
                this.listLoading = true
                fetchList(this.listQuery).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            handleAdd() {
                this.item = Object.assign({}, defaultUser)
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
                    await deleteUser(row.id)
                    this.list.splice($index, 1)
                    this.$message({
                        type: 'success',
                        message: 'Delete succed!'
                    })
                })
                .catch(err => { console.error(err) })
            },
            async confirmUser() {
                const isEdit = this.dialogType === 'edit'

                if (isEdit) {
                    await updateUser(this.item.id, this.item)
                    for (let index = 0; index < this.list.length; index++) {
                        if (this.list[index].id === this.item.id) {
                            this.list.splice(index, 1, Object.assign({}, this.item))
                            break
                        }
                    }
                } else {
                    const { data } = await addUser(this.item)
                    this.item.id = data.id
                    this.list.push(this.item)
                }

                const { name } = this.item
                this.dialogVisible = false
                this.$notify({
                    title: 'Success',
                    dangerouslyUseHTMLString: true,
                    message: `
                        <div>Nav Name: ${name}</div>
                      `,
                    type: 'success'
                })
            },
            handleAvatarSuccess(res, file) {
                if(res.code != 20000){
                    this.$message.error(res.message);
                    return;
                }
                this.item.avatar = res.data.location;
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
</style>
