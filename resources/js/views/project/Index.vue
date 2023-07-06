<!--<template>-->
<!--    <div v-if="!isDelete">-->
<!--        <div class="bg-white shadow overflow-hidden sm:rounded-lg">-->
<!--            <div class="grid grid-cols-4">-->
<!--                <div class="px-6 py-4 bg-gray-100 text-gray-800 font-medium">-->
<!--                    <router-link-->
<!--                        :to="{ name: 'tasks.index', params: { projectId: project.id } }"-->
<!--                        class="hover:text-indigo-600"-->
<!--                    >-->
<!--                        {{ project.title }}-->
<!--                    </router-link>-->
<!--                </div>-->
<!--                <div class="px-6 py-4 text-gray-500 whitespace-pre-line">-->
<!--                    {{ project.description }}-->
<!--                </div>-->
<!--                <div class="px-6 py-4 text-gray-500">-->
<!--                    {{ project.duration }}-->
<!--                </div>-->
<!--                <div class="px-6 py-4 flex justify-end space-x-2">-->
<!--                    <router-link-->
<!--                        :to="{ name: 'project.edit', params: { id: project.id } }"-->
<!--                        class="text-gray-500 hover:text-indigo-600"-->
<!--                    >-->
<!--                        <svg-->
<!--                            class="h-5 w-5 fill-current"-->
<!--                            viewBox="0 0 20 20"-->
<!--                            xmlns="http://www.w3.org/2000/svg"-->
<!--                        >-->
<!--                            <path-->
<!--                                d="M14.7 4.3a1 1 0 00-1.4 0l-8 8a1 1 0 000 1.4l3 3a1 1 0 001.4 0l8-8a1 1 0 000-1.4l-3-3zM7 11.59V13h1.41l5.3-5.3-1.42-1.42L7 11.59z"-->
<!--                            />-->
<!--                        </svg>-->
<!--                    </router-link>-->
<!--                    <button-->
<!--                        @click="deleteProject(project)"-->
<!--                        class="text-gray-500 hover:text-red-600"-->
<!--                    >-->
<!--                        <svg-->
<!--                            class="h-5 w-5 fill-current"-->
<!--                            viewBox="0 0 20 20"-->
<!--                            xmlns="http://www.w3.org/2000/svg"-->
<!--                        >-->
<!--                            <path-->
<!--                                fill-rule="evenodd"-->
<!--                                d="M9.293 10L4.146 4.854a1 1 0 011.414-1.414L10 8.586l4.439-4.439a1 1 0 011.414 1.414L11.707 10l4.146 4.146a1 1 0 01-1.414 1.414L10 11.414l-4.439 4.439a1 1 0 01-1.414-1.414L8.293 10z"-->
<!--                                clip-rule="evenodd"-->
<!--                            />-->
<!--                        </svg>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div v-if="error.length > 0" class="px-6 py-4 bg-red-100 text-red-700">-->
<!--                {{ error }}-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->


<template>
    <div v-if="!isDelete">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="grid grid-cols-4">
                <div class="px-6 py-4 bg-gray-100 text-gray-800 font-medium">
                    <router-link
                        :to="{ name: 'tasks.index', params: { projectId: project.id } }"
                        class="hover:text-indigo-600"
                    >
                        {{ project.title }}
                    </router-link>
                </div>
                <div class="px-6 py-4 text-gray-500 whitespace-pre-line">
                    {{ project.description }}
                </div>
                <div class="px-6 py-4 text-gray-500">
                    {{ !noTasksProj ? project.duration : '' }}
                </div>
                <div class="px-6 py-4 flex items-center">
                    <div class="flex space-x-2">
                        <router-link
                            :to="{ name: 'project.edit', params: { id: project.id } }"
                            class="text-gray-500 hover:text-indigo-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>

                        </router-link>
                        <button
                            @click="deleteProject(project)"
                            class="text-gray-500 hover:text-red-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>

                        </button>
                    </div>
                </div>
            </div>
            <div v-if="error.length > 0" class="px-6 py-4 bg-red-100 text-red-700">
                {{ error }}
            </div>
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
                error: [],
                noTasksProj: this.project.duration === "1 second" ? true : false
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
                        .then(res => {
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
