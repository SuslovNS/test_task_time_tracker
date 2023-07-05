<template>
    <div v-if="!isDelete">
    <div class="mb-8 pb-8 border-b border-gray-400">
        <div class="flex justify-between">
            <div>
                <router-link :to="{name:'tasks.index', params: {projectId: project.id}} "
                             class="text-lg font-medium text-gray-900 hover:text-gray-600">{{ project.title }}
                </router-link>
            </div>
            <div class="text-lg font-medium text-gray-900 hover:text-gray-600l">{{ project.description }}</div>
            <div class="text-lg font-medium text-gray-900 hover:text-gray-600l">{{project.duration}}}</div>
            <div class="flex items-center space-x-4">
                <router-link :to="{name:'project.edit', params: {id: project.id}}"
                             class="text-gray-500 hover:text-gray-700">Edit
                </router-link>
                <button @click="deleteProject(project)" class="text-red-500 hover:text-red-700">Delete
                </button>
            </div>
        </div>
        <div v-if="error.length > 0">
            <p class="text-sm mt-2 text-red-500">{{error}}</p>
        </div>

        <!--        <ul class="divide-y divide-gray-200">-->
        <!--            <li v-for="task in tasks" :key="task.id" class="py-4">-->
        <!--                <div class="flex justify-between">-->
        <!--                    <div>-->
        <!--                        {{ task.title }}-->
        <!--                    </div>-->
        <!--                    <div class="flex items-center space-x-4">-->
        <!--                        <button v-if="!task.is_running" @click="startTask(task)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Start</button>-->
        <!--                        <button v-else @click="stopTask(task)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Stop</button>-->
        <!--                        <button @click="deleteTask(task.id)" class="text-red-500 hover:text-red-700">Delete</button>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </li>-->
        <!--        </ul>-->
    </div>
    </div>
</template>

<script>
    export default {
        name: "Project",
        props: [
            'project'
        ],
        data() {
            return {
                title: '',
                id: '',
                description: '',
                tasks: [],
                isDelete: false,
                error: []
            }
        },

        mounted() {
            // this.loadProject()
            // this.loadTasks()
        },

        methods: {
            // async loadProject() {
            //     const response = await axios.get(`/api/projects/${this.$route.params.id}`)
            //     this.project = response.data
            // },
            //
            // async loadTasks() {
            //     const response = await axios.get(`/api/projects/${this.$route.params.id}/tasks`)
            //     this.tasks = response.data
            // },

            deleteProject(project) {
                if (confirm('Are you sure you want to delete this project?')) {
                    axios.delete(`/api/projects/${project.id}/delete`)
                    .then( res => {
                        this.isDelete = true
                    }).catch(e => {
                        this.error = e
                    })
                }
            }

            // async startTask(task) {
            //     const response = await axios.post('/api/time-logs/start', {
            //         task_id: task.id
            //     })
            //     task.is_running = true
            //     task.time_log = response.data.time_log
            // },
            //
            // async stopTask(task) {
            //     const response = await axios.put(`/api/time-logs/stop/${task.time_log.id}`)
            //     task.is_running = false
            //     task.time_log = response.data.time_log
            // },
            //
            // async deleteTask(id) {
            //     if (confirm('Are you sure you want to delete this task?')) {
            //         await axios.delete(`/api/tasks/${id}`)
            //         this.loadTasks()
            //     }
            // }
        }
    }
</script>

<style scoped>

</style>
