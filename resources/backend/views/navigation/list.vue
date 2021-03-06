<template>
    <div class="app-container">
        <el-button type="primary" @click="handleAdd">新建</el-button>
        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="名称">
                <template slot-scope="scope">
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>

            <el-table-column width="300px" align="center" label="备注">
                <template slot-scope="scope">
                    <span>{{ scope.row.remark }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="更新时间">
                <template slot-scope="scope">
                    <span>{{ scope.row.updated_at}}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="创建时间">
                <template slot-scope="scope">
                    <span>{{ scope.row.created_at}}</span>
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

        <el-dialog :visible.sync="dialogVisible" :title="dialogType==='edit'?'Edit Nav':'New Nav'">
            <el-form ref="form" :model="item" label-width="80px">
                <el-form-item label="name">
                    <el-input v-model="item.name"></el-input>
                </el-form-item>
                <el-form-item label="remark">
                    <el-input v-model="item.remark"></el-input>
                </el-form-item>
            </el-form>
            <div style="text-align:right;">
                <el-button type="danger" @click="dialogVisible=false">Cancel</el-button>
                <el-button type="primary" @click="confirmNav">Confirm</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { fetchList,addNav,updateNav,deleteNav } from '@/api/navigation'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'

    const defaultNav = {
        id: '',
        name: '',
        remark: ''
    }

    export default {
        name: 'ArticleList',
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
                this.item = Object.assign({}, defaultNav)
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
                    await deleteNav(row.id)
                    this.list.splice($index, 1)
                    this.$message({
                        type: 'success',
                        message: 'Delete succed!'
                    })
                })
                .catch(err => { console.error(err) })
            },
            async confirmNav() {
                const isEdit = this.dialogType === 'edit'

                if (isEdit) {
                    await updateNav(this.item.id, this.item)
                    for (let index = 0; index < this.list.length; index++) {
                        if (this.list[index].id === this.item.id) {
                            this.list.splice(index, 1, Object.assign({}, this.item))
                            break
                        }
                    }
                } else {
                    const { data } = await addNav(this.item)
                    this.item.id = data.id
                    this.list.push(this.item)
                }

                const { id, remark, name } = this.item
                this.dialogVisible = false
                this.$notify({
                    title: 'Success',
                    dangerouslyUseHTMLString: true,
                    message: `
                        <div>Nav Name: ${name}</div>
                        <div>Nav Remark: ${remark}</div>
                      `,
                    type: 'success'
                })
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
</style>
