<template>
<div>
    <el-breadcrumb separator="/">
        <el-breadcrumb-item :to="{ path: '/home' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item>用户管理</el-breadcrumb-item>
        <el-breadcrumb-item>用户列表</el-breadcrumb-item>
    </el-breadcrumb>

    <el-card>
        <el-row :gutter="20">
                <el-col :span='9'>
                    <el-input placeholder="请输入内容">
                        <el-button slot="append" icon="el-icon-search"></el-button>
                    </el-input>
                </el-col>
                <el-col :span='4'>
                    <el-button type="primary">添加用户</el-button>
                </el-col>
            </el-row>
            <el-table :data="tableData" border stripe max-height="250">
                <el-table-column
                    type="index">
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="姓名"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="邮箱"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="mobile"
                    label="电话">
                </el-table-column>
                <el-table-column
                    prop="role_name"
                    label="角色">
                </el-table-column>
                <el-table-column
                    prop="mg_state"
                    label="状态">
                    <!--作用域插槽-->
                    <template slot-scope="scope">
                        <el-switch v-model="scope.row.mg_state"> </el-switch>
                    </template>
                </el-table-column>
                <el-table-column
                    label="操作" width="180px">
                    <template slot-scope="scope">
                        <el-button type='primary' icon="el-icon-edit" size="mini"></el-button>
                        <el-button type='danger' icon="el-icon-delete" size="mini"></el-button>
                        <el-tooltip  effect="dark" content="分配权限" placement="top" :enterable="false">
                            <el-button type='warning' icon="el-icon-setting" size="mini"></el-button>
                        </el-tooltip>
                    </template>
                </el-table-column>
            </el-table>

            <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :current-page="queryInfo.pagenum"
            :page-sizes="[1, 2, 5, 10]"
            :page-size="queryInfo.pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total">
            </el-pagination>
    </el-card>
</div>

</template>

<script>
export default {
    data() {
        return {
            queryInfo: {
                query: '',
                pagenum: 1,
                pagesize: 2
            },
            userList: [],
            total: 0,
            tableData: [{
                mobile: '18735386269',
                name: '王小虎',
                email: '18735386269@163.com',
                role_name: '操作管理员',
                mg_state: false,
                address: '上海市普陀区金沙江路 1518 弄'
            }, {
                mobile: '18735386269',
                name: '王小虎',
                email: '18735386269@163.com',
                role_name: '操作管理员',
                mg_state: true,
                address: '上海市普陀区金沙江路 1518 弄'
            }, {
                mobile: '18735386269',
                name: '王小虎',
                email: '18735386269@163.com',
                role_name: '操作管理员',
                mg_state: true,
                address: '上海市普陀区金沙江路 1518 弄'
            }, {
                mobile: '18735386269',
                name: '王小虎',
                email: '18735386269@163.com',
                role_name: '操作管理员',
                mg_state: false,
                address: '上海市普陀区金沙江路 1518 弄'
            }]
        }
    },
    created() {
        this.getUserList()
    },
    methods: {
       async getUserList() {
       const {data: res} = await this.$http.get('users',{params: this.queryInfo })
            console.log(res)
            if(res.meta.code !== 200) return this.$message.error(res.meta.msg)
            this.userList = res.data.users
            this.total = res.data.total
        },
        handleSizeChange(newSize) {
            this.queryInfo.pagesize = newSize
            this.getUserList()
        },
        handleCurrentChange(newPage) {
            this.queryInfo.pagenum = newPage
            this.getUserList()
        }
    }
}
</script>

<style lang="less" scoped>

</style>