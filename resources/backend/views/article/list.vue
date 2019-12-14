<template>
    <div class="app-container">
        <router-link to="/Article/Create">
            <el-button type="primary">新建</el-button>
        </router-link>
        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="标题">
                <template slot-scope="scope">
                    <span>{{ scope.row.title }}</span>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="别名">
                <template slot-scope="scope">
                    <span>{{ scope.row.alias}}</span>
                </template>
            </el-table-column>

            <el-table-column width="100px" align="center" label="分类">
                <template slot-scope="scope">
                    <el-tag
                        :key="index"
                        v-for="(categorie,index) in scope.row.categories">
                        {{categorie.title}}
                    </el-tag>
                </template>
            </el-table-column>

            <el-table-column width="200px" align="center" label="标签">
                <template slot-scope="scope">
                    <el-tag
                        :key="index"
                        v-for="(tag,index) in scope.row.tags">
                        {{tag.name}}
                    </el-tag>
                </template>
            </el-table-column>

            <el-table-column width="280px" align="center" label="内容">
                <template slot-scope="scope">
                    <div style="height: 280px" v-html="scope.row.content"></div>
                </template>
            </el-table-column>

            <el-table-column width="100px" align="center" label="缩略图">
                <template slot-scope="scope">
                    <img style="height: 100px" :src="scope.row.thumbnail"></img>
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
    </div>
</template>

<script>
    import { fetchList,deleteArticle } from '@/api/article'
    import Pagination from '@/components/Pagination'

    export default {
        name: 'ArticleList',
        components: { Pagination},
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
            handleEdit(scope) {
                this.$router.push({
                    path: '/Article/Create',
                    query: {
                        article_id: scope.row.id
                    }
                })
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
</style>
