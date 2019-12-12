<!-- file.vue -->
<template>
    <div class="file">
        <el-input style="width:30%" v-model="file.name" placeholder="请输入附件名称"></el-input>
        <el-input style="width:50%" v-model="file.uri" placeholder="请输入附件地址"></el-input>
        <button @click="onCloseClick">×</button>
    </div>
</template>
<script>
    export default {
        name: "file",
        data () {
            return{
                file: {
                    name: '',
                    uri: ''
                }
            }
        },
        props: {
            item: {
                name: String,
                uri: String
            },
            index: Number
        },
        methods: {
            onCloseClick () {
                // 将删除标签事件暴露除去
                this.$emit("delete", this.index);
            }
        },
        watch: {
            item: {
                handler (newV, oldV) {
                    console.log(newV.name)
                    this.file.name = newV.name;
                    this.file.uri = newV.uri;
                },
                deep: true
            },
            file: {
                handler (newV, oldV) {
                    if (newV.name.length === 0) {
                        return false
                    }
                    if (newV.uri.length === 0) {
                        return false
                    }
                    this.$emit('upload', {index: this.index, data: newV})
                },
                deep: true
            },
        }
    }
</script>
<style scoped>
    .file {
        display: inline-block;
        margin: 3px;
    }
</style>
