<template>
    <div v-if="!isDelete">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="flex justify-between">
                <div class="px-6 py-4 text-lg font-medium text-gray-900 hover:text-indigo-600">
                    {{ task.title }}
                </div>
                <div class="px-6 py-4 text-lg font-medium text-gray-900 hover:text-indigo-600">
                    {{ task.description }}
                </div>
                <div v-if="!task.stoped_time" class="px-6 py-4 flex items-center space-x-40">
                    <button
                        v-if="!isStarted"
                        @click.prevent="startTask(task)"
                        class="text-lg font-medium text-gray-900 hover:text-indigo-600"
                    >
                        Start
                    </button>
                    <button
                        v-if="!isStoped"
                        @click.prevent="stopTask(task)"
                        class="text-lg font-medium text-gray-900 hover:text-indigo-600"
                    >
                        Stop
                    </button>
                </div>
                <div v-else class="px-6 py-4 flex items-center space-x-4">
                    <div class="font-medium text-green-900 hover:text-indigo-600">
                        Started at {{ task.started_time }}
                    </div>
                    <div class="font-medium text-red-900 hover:text-indigo-600">
                        Stopped at {{ task.stoped_time }}
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center space-x-4">
                    <router-link
                        :to="{
              name: 'tasks.edit',
              params: { projectId: projId, taskId: task.id }
            }"
                        class="text-gray-500 hover:text-indigo-600"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                        Edit
                    </router-link>
                    <button
                        @click="deleteTask(task)"
                        class="text-red-500 hover:text-red-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
            <div v-if="message.length > 0" class="px-6 py-4 bg-green-100 text-green-700">
                {{ message }}
            </div>
            <div v-if="error.length > 0" class="px-6 py-4 bg-red-100 text-red-700">
                <p class="text-sm mt-2">{{ error }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Task",
        props: [
            'task',
            'projId'
        ],
        data() {
            return {
                title: '',
                id: '',
                description: '',
                isDelete: false,
                error: [],
                message: [],
                isStarted: !!this.task.started_time,
                isStoped:!!this.task.stoped_time,
            }
        },

        methods: {
            loadTask(task) {
                axios.get(`/projects/${this.projId}/tasks/${task.id}`)
            },

            startTask(task) {
                axios.patch(`/api/projects/${this.projId}/tasks/${task.id}/start`)
                    .then(res => {
                        this.message = res.data.message
                        this.isStarted = true
                    })
            },

            stopTask(task) {
                axios.patch(`/api/projects/${this.projId}/tasks/${task.id}/stop`)
                    .then(res => {
                        this.message = res.data.message
                        this.isStoped = true
                    })
            },

            deleteTask(task, projId) {
                if (confirm('Are you sure you want to delete this task?')) {
                    axios.delete(`/api/projects/${this.projId}/tasks/${task.id}/delete`)
                        .then(res => {
                            this.isDelete = true
                        }).catch(e => {
                        this.error = e
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
