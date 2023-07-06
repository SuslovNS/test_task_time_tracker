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
        },

        methods: {
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
        }
    }
</script>

<style scoped>

</style>
