<template>
    <div class="app-container">
        <el-button type="primary" @click="handleAdd">新建</el-button>
        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="60px" align="center" label="父级">
                <template slot-scope="scope">
                    <el-avatar :src="scope.row.parent_id"></el-avatar>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="分类名称">
                <template slot-scope="scope">
                    <span>{{ scope.row.title }}</span>
                </template>
            </el-table-column>

            <el-table-column width="300px" align="center" label="关键字">
                <template slot-scope="scope">
                    <span>{{ scope.row.keywords }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="描述">
                <template slot-scope="scope">
                    <span>{{ scope.row.description}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="状态">
                <template slot-scope="scope">
                    <span>{{ scope.row.status}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="排序">
                <template slot-scope="scope">
                    <span>{{ scope.row.list_order}}</span>
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

                <el-form-item label="父级">
                    <el-select v-model="item.parent_id" placeholder="请选择">
                        <el-option
                            v-for="item in cateforyList"
                            :key="item.id"
                            :label="item.title"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="分类名称">
                    <el-input v-model="item.title"></el-input>
                </el-form-item>

                <el-form-item label="关键字">
                    <el-input v-model="item.keywords"></el-input>
                </el-form-item>

                <el-form-item label="描述">
                    <el-input v-model="item.description"></el-input>
                </el-form-item>

                <el-form-item label="排序">
                    <el-input v-model="item.list_order"></el-input>
                </el-form-item>

                <el-form-item label="状态">
                    <template>
                        <el-radio v-model="item.status" label="0">隐藏</el-radio>
                        <el-radio v-model="item.status" label="1">开启</el-radio>
                    </template>
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
    import { getCategoryAllList, fetchList,addCategory,updateCategory,deleteCategory } from '@/api/category'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'

    const defaultFields = {
        id: '',
        parent_id: '',
        title: '',
        keywords: '',
        description: '',
        status: '',
        list_order: '0',
        more: ''
    }

    export default {
        name: 'CategoryList',
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
                cateforyList: null,
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
            this.getCategoryAllList()
        },
        methods: {
            getCategoryAllList() {
                getCategoryAllList(this.listQuery).then(response => {
                    this.cateforyList = response.data.items
                })
            },
            getList() {
                this.listLoading = true
                fetchList(this.listQuery).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            handleAdd() {
                this.item = Object.assign({}, defaultFields)
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
                    await deleteCategory(row.id)
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
                    await updateCategory(this.item.id, this.item)
                    for (let index = 0; index < this.list.length; index++) {
                        if (this.list[index].id === this.item.id) {
                            this.list.splice(index, 1, Object.assign({}, this.item))
                            break
                        }
                    }
                } else {
                    const { data } = await addCategory(this.item)
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
