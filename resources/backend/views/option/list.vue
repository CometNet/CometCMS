<template>
    <div class="app-container">
        <el-button type="primary" @click="handleAdd">新建</el-button>
        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="配置名称">
                <template slot-scope="scope">
                    <span>{{ scope.row.option_name }}</span>
                </template>
            </el-table-column>

            <el-table-column width="300px" align="center" label="配置描述">
                <template slot-scope="scope">
                    <span>{{ scope.row.description }}</span>
                </template>
            </el-table-column>

            <el-table-column width="300px" align="center" label="配置内容">
                <template slot-scope="scope">
                    <span>{{ scope.row.option_value }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="操作" width="200">
                <template slot-scope="scope">
                    <el-button type="primary" size="small" icon="el-icon-edit" @click="handleEdit(scope)">
                        修改
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
                <el-form-item label="配置名称">
                    <el-input :disabled="isEdit()" v-model="item.option_name"></el-input>
                </el-form-item>
                <el-form-item label="配置描述">
                    <el-input v-model="item.description"></el-input>
                </el-form-item>
                <el-form-item label="配置内容">
                    <el-input v-model="item.option_value"></el-input>
                </el-form-item>
            </el-form>
            <div style="text-align:right;">
                <el-button type="danger" @click="dialogVisible=false">Cancel</el-button>
                <el-button type="primary" @click="confirmOption">Confirm</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { fetchList,addOption,updateOption,deleteOption } from '@/api/option'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'

    const defaultOption = {
        id: '',
        option_name: '',
        description: '',
        option_value: ''
    }

    export default {
        name: 'OptionList',
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
            isEdit() {
                return this.dialogType === 'edit' ? true : false
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
                this.item = Object.assign({}, defaultOption)
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
                    await deleteOption(row.id)
                    this.list.splice($index, 1)
                    this.$message({
                        type: 'success',
                        message: 'Delete succed!'
                    })
                })
                .catch(err => { console.error(err) })
            },
            async confirmOption() {
                const isEdit = this.dialogType === 'edit'

                if (isEdit) {
                    await updateOption(this.item.id, this.item)
                    for (let index = 0; index < this.list.length; index++) {
                        if (this.list[index].id === this.item.id) {
                            this.list.splice(index, 1, Object.assign({}, this.item))
                            break
                        }
                    }
                } else {
                    const { data } = await addOption(this.item)
                    this.item.id = data.id
                    this.list.push(this.item)
                }

                const { id, option_value, option_name } = this.item
                this.dialogVisible = false
                this.$notify({
                    title: 'Success',
                    dangerouslyUseHTMLString: true,
                    message: `
                        <div>Nav Name: ${option_name}</div>
                        <div>Nav Remark: ${option_value}</div>
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
