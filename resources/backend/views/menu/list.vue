<template>
    <div class="app-container">
        <el-button type="primary" @click="handleAdd">New Nav</el-button>
        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="Date">
                <template slot-scope="scope">
                    <span>{{ scope.row.nav_id}}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Author">
                <template slot-scope="scope">
                    <span>{{ scope.row.parent_id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Author">
                <template slot-scope="scope">
                    <span>{{ scope.row.status }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Author">
                <template slot-scope="scope">
                    <span>{{ scope.row.name }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Author">
                <template slot-scope="scope">
                    <span>{{ scope.row.icon }}</span>
                </template>
            </el-table-column>

            <el-table-column min-width="300px" label="Title">
                <template slot-scope="{row}">
                    <router-link :to="'/example/edit/'+row.id" class="link-type">
                        <span>{{ row.title }}</span>
                    </router-link>
                </template>
            </el-table-column>

            <el-table-column align="center" label="Actions" width="120">
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
                <el-form-item label="name">
                    <el-input v-model="item.name"></el-input>
                </el-form-item>
                <el-form-item label="nav_id">
                    <el-input v-model="item.nav_id"></el-input>
                </el-form-item>
                <el-form-item label="parent_id">
                    <el-input v-model="item.parent_id"></el-input>
                </el-form-item>
                <el-form-item label="status">
                    <el-input v-model="item.status"></el-input>
                </el-form-item>
                <el-form-item label="href">
                    <el-input v-model="item.href"></el-input>
                </el-form-item>
                <el-form-item label="target">
                    <el-input v-model="item.target"></el-input>
                </el-form-item>
                <el-form-item label="icon">
                    <el-input v-model="item.icon"></el-input>
                </el-form-item>
            </el-form>
            <div style="text-align:right;">
                <el-button type="danger" @click="dialogVisible=false">Cancel</el-button>
                <el-button type="primary">Confirm</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import { fetchList } from '@/api/navigation'
    import Pagination from '@/components/Pagination'
    import { deepClone } from '@/utils'

    const defaultMenu = {
        nav_id: '',
        parent_id: '',
        status: '',
        list_order: '',
        name: '',
        href: '',
        target: '',
        icon: ''
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
                this.$confirm('Confirm to remove the role?', 'Warning', {
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                })
                    .then(async() => {

                    })
                    .catch(err => { console.error(err) })
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
