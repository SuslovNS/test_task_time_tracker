<template>
    <div v-if="!isDelete">
        <div class="mb-8 pb-8 border-b border-gray-400">
            <div class="flex justify-between">
                <div class="text-lg font-medium text-gray-900 hover:text-gray-600">
                    {{ task.title }}
                </div>
                <div class="text-lg font-medium text-gray-900 hover:text-gray-600l">{{ task.description }}</div>
                <div v-if="!task.stoped_time"  class="flex items-center space-x-40">
                    <button v-if="!task.started_time" @click.prevent="startTask(task)"
                            class="text-lg font-medium text-gray-900 hover:text-gray-600l">Start
                    </button>
                    <button @click.prevent="stopTask(task)"
                            class="text-lg font-medium text-gray-900 hover:text-gray-600l">Stop
                    </button>
                </div>
                <div v-else class="text-lg font-medium text-gray-900 hover:text-gray-600l">Stoped at {{task.stoped_time}}</div>
                <div class="flex items-center space-x-4">
                    <router-link :to="{name:'tasks.edit', params: {projectId: this.projId, taskId: this.task.id}}"
                                 class="text-gray-500 hover:text-gray-700">Edit
                    </router-link>
                    <button @click="deleteTask(task)" class="text-red-500 hover:text-red-700">Delete
                    </button>
                </div>
            </div>
<div v-if="message.length >0" class="text-center text-green-500">
    {{message}}
</div>
            <div v-if="error.length > 0">
                <p class="text-sm mt-2 text-red-500">{{error}}</p>
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
                message: []
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
                        this.loadTask()
                    })
            },

            pauseTask(task) {
                axios.patch(`/api/projects/${this.projId}/tasks/${task.id}/pause`)
                    .then(res => {
                        this.message = res.data.message
                    })
            },

            stopTask(task) {
                axios.patch(`/api/projects/${this.projId}/tasks/${task.id}/stop`)
                    .then(res => {
                        this.message = res.data.message
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
