<template>
    <div class="app-container">
        <el-row>
            <el-col :span="6">
                <el-button type="primary" @click="handleAdd">新建</el-button>
                <template>
                    <el-select v-model="search" placeholder="请选择">
                        <el-option
                            v-for="item in navList"
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
            <el-table-column min-width="80px"  width="80" label="ID">
                <template slot-scope="{row}">
                    <span>{{ row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="名称" width="200">
                <template slot-scope="scope">
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="导航">
                <template slot-scope="scope">
                    <span>{{ scope.row.nav_id}}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="上级">
                <template slot-scope="scope">
                    <span>{{ scope.row.parent_id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="状态">
                <template slot-scope="scope">
                    <span>{{ scope.row.status }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="图标">
                <template slot-scope="scope">
                    <span>{{ scope.row.icon }}</span>
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

        <el-dialog :visible.sync="dialogVisible" :title="dialogType==='edit'?'Edit Menu':'New Menu'">
            <el-form ref="form" :model="item" label-width="80px">
                <el-form-item label="名称">
                    <el-input v-model="item.name"></el-input>
                </el-form-item>

                <el-form-item label="导航">
                    <el-select v-model="item.nav_id" placeholder="请选择">
                        <el-option
                            v-for="item in navList"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="上级菜单">
                    <el-select v-model="item.parent_id" placeholder="请选择">
                        <el-option
                            v-for="item in list"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="排序">
                    <el-input v-model="item.list_order"></el-input>
                </el-form-item>

                <el-form-item label="状态">
                    <template>
                        <el-radio v-model="item.status" label="1">显示</el-radio>
                        <el-radio v-model="item.status" label="0">隐藏</el-radio>
                    </template>
                </el-form-item>

                <el-form-item label="地址">
                    <el-input v-model="item.href"></el-input>
                </el-form-item>

                <el-form-item label="打开方式">
                    <template>
                        <el-radio v-model="item.target" label="1">_self</el-radio>
                        <el-radio v-model="item.target" label="0">_blank</el-radio>
                    </template>
                </el-form-item>

                <el-form-item label="图标">
                    <el-input v-model="item.icon"></el-input>
                </el-form-item>

            </el-form>
            <div style="text-align:right;">
                <el-button type="danger" @click="dialogVisible=false">Cancel</el-button>
                <el-button type="primary" @click="confirmMenu">Confirm</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { fetchList, addMenu, deleteMenu, updateMenu, getNavList} from '@/api/menu'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'

    const defaultMenu = {
        id: '',
        nav_id: 0,
        parent_id: 0,
        status: '1',
        list_order: 10000,
        name: '',
        href: '',
        target: 0,
        icon: ''
    }

    export default {
        name: 'MenuList',
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
                navList: {},
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
            this.getNavAllList()
        },
        watch: {
            search(val,oldVal){
                console.log(val)
                fetchList(this.listQuery,val).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            }
        },
        methods: {
            getNavAllList() {
                getNavList(this.listQuery).then(response => {
                    this.navList = response.data.items
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
                this.item = Object.assign({}, defaultMenu)
                this.dialogType = 'new'
                this.dialogVisible = true
            },
            handleEdit(scope) {
                this.dialogType = 'edit'
                this.dialogVisible = true
                this.item = deepClone(scope.row)
                this.$nextTick(() => {

                })
            },
            handleDelete({ $index, row }) {
                this.$confirm('Confirm to remove the Navigation?', 'Warning', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                })
                .then(async() => {
                    await deleteMenu(row.id)
                    this.list.splice($index, 1)
                    this.$message({
                        type: 'success',
                        message: 'Delete succed!'
                    })
                })
                .catch(err => { console.error(err) })
            },
            async confirmMenu() {
                const isEdit = this.dialogType === 'edit'

                if (isEdit) {
                    await updateMenu(this.item.id, this.item)
                    for (let index = 0; index < this.list.length; index++) {
                        if (this.list[index].id === this.item.id) {
                            this.list.splice(index, 1, Object.assign({}, this.item))
                            break
                        }
                    }
                } else {
                    const { data } = await addMenu(this.item)
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
