<template>
    <div class="container mx-auto">
        <div class="text-center">
            <div class="flex justify-center" v-if="!adding">
                <svg @click="adding = true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor"
                     :class="['mr-2 stroke-black-500 cursor-pointer hover:fill-red-500 w-6 h-6', 'fill-white' ]">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Add Task</p>
            </div>
            <div v-if="adding" @click="adding = false" class="cursor-pointer text-center">Close</div>
            <div v-if="adding">
                <div class="mb-6">
                    <div class="flex-grow">
                        <label for="project-name" class="block text-gray-700 font-bold mb-2">Task Name</label>
                        <input type="text" id="project-name" v-model="newTaskName"
                               class="w-96  rounded-3xl border p-2 border-slate-400"
                               required>
                    </div>
                    <div v-if="errors.title">
                        <p v-for="error in errors.title" class="text-sm mt-2 text-red-500">{{error}}</p>
                    </div>
                    <div class="flex-grow">
                        <label for="project-description" class="block text-gray-700 font-bold mb-2">Task
                            Description</label>
                        <input type="text" id="project-description" v-model="newTaskDescription"
                               class="w-96  rounded-3xl border p-2 border-slate-400"
                               required>
                    </div>
                    <div v-if="errors.description">
                        <p v-for="error in errors.description" class="text-sm mt-2 text-red-500">{{error}}</p>
                    </div>
                </div>
                <div>
                    <a @click.prevent="createTask" href="#" class="block p-2 w-32 text-center rounded-3xl bg-red-600 text-white
            hover:bg-white hover:border hover:border-red-600 hover:text-red-600 ml-auto">Create</a>
                </div>
            </div>
        </div>
        <div v-if="tasks.length > 0">
            <h1 class="text-2xl font-bold mb-6 text-center">Tasks</h1>
            <Task v-for="task in tasks" :task="task" :projId="this.projectId"></Task>
        </div>
        <div v-else>
            <h1 class="text-2xl font-bold mb-6 text-center">No Tasks</h1>
        </div>
    </div>
</template>

<script>
    import Task from "../tasks/Task.vue";
    export default {
        name: "Index",
        components: {
          Task
        },
        data() {
            return {
                tasks: [],
                projectId:this.$route.params.projectId,
                adding: false,
                newTaskName: '',
                newTaskDescription: '',
                errors: []
            }
        },

        mounted() {
            this.loadTasks()
        },

        methods: {

            loadTasks() {
                const params = {
                    id: this.projectId,
                }
                axios.get(`/api/projects/${this.projectId}/tasks`, {params} )
                    .then(res => {
                        this.tasks = res.data.data
                    })
            },

            createTask() {
                axios.post(`/api/projects/${this.projectId}/tasks`, {
                    title: this.newTaskName,
                    description: this.newTaskDescription,
                    project_id:this.projectId
                })
                    .then(res => {
                        this.tasks.push(res.data.data)
                        this.newTaskName = ''
                        this.newTaskDescription = ''
                    })
                    .catch(e => {
                        this.errors = e.response.data.errors
                    })
            },


        },
    }
</script>

<style scoped>

</style>
