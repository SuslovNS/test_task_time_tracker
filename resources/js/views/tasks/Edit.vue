<template>
    <div >
        <div class="mb-6 text-center">
            <div class="flex-grow">
                <label for="project-name" class="block text-gray-700 font-bold mb-2">Task Name</label>
                <input type="text" id="project-name" v-model="task.title"
                       class="w-96  rounded-3xl border p-2 border-slate-400"
                       required>
            </div>
            <div v-if="errors.title">
                <p v-for="error in errors.title" class="text-sm mt-2 text-red-500">{{error}}</p>
            </div>
            <div class="flex-grow">
                <label for="task-description" class="block text-gray-700 font-bold mb-2">Task Description</label>
                <input type="text" id="task-description" v-model="task.description"
                       class="w-96  rounded-3xl border p-2 border-slate-400"
                       required>
            </div>
            <div v-if="errors.description">
                <p v-for="error in errors.description" class="text-sm mt-2 text-red-500">{{error}}</p>
            </div>
        </div>
        <div>
            <a @click.prevent="editTask(task)" href="#" class="block p-2 w-32 text-center rounded-3xl bg-red-600 text-white
            hover:bg-white hover:border hover:border-red-600 hover:text-red-600 ml-auto">Edit</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Edit",
        data () {
            return {
                projId: this.$route.params.projectId,
                taskId: this.$route.params.taskId,
                task: [],
                errors: []
            }
        },

        mounted() {
            this.loadTask()
        },

        methods: {
            loadTask() {
                axios.get(`/api/projects/${this.projId}/tasks/${this.taskId}`)
                    .then( res => {
                        this.task = res.data.data
                    })
            },

            editTask(task) {
                axios.patch(`/api/projects/${this.projId}/tasks/${task.id}`, {
                    title: this.task.title,
                    description: this.task.description
                })
                    .then( res => {
                        this.$router.push({name: 'tasks.index'})
                    })
                    .catch(e => {
                        this.errors = e.response.data.errors
                    })
            },


        }
    }
</script>

<style scoped>

</style>
