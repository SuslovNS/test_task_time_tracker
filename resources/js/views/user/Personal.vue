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
                <p>Add project</p>
            </div>
            <div v-if="adding" @click="adding = false" class="cursor-pointer text-center">Close</div>
            <div v-if="adding" class="max-w-lg mx-auto mt-8 bg-white shadow-md rounded-lg overflow-hidden">
                <div class="py-4 px-6">
                    <h2 class="text-2xl font-bold mb-4">Add Project</h2>
                    <form>
                        <div class="mb-4">
                            <label for="project-name" class="block text-gray-700 font-bold mb-2">Project Name</label>
                            <input
                                type="text"
                                id="project-name"
                                v-model="newProjectName"
                                class="w-full px-4 py-2 rounded-lg border border-gray-400 focus:outline-none focus:border-indigo-500"
                                required
                            >
                            <div v-if="errors.title">
                                <p v-for="error in errors.title" class="text-sm mt-2 text-red-500">{{ error }}</p>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="project-description" class="block text-gray-700 font-bold mb-2">Project Description</label>
                            <textarea
                                id="project-description"
                                v-model="newProjectDescription"
                                class="w-full px-4 py-2 rounded-lg border border-gray-400 focus:outline-none focus:border-indigo-500"
                                rows="4"
                                required
                            ></textarea>
                            <div v-if="errors.description">
                                <p v-for="error in errors.description" class="text-sm mt-2 text-red-500">{{ error }}</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button
                                @click.prevent="createProject"
                                class="px-4 py-2 rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600"
                            >
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div v-if="projects.length > 0">
            <h1 class="text-2xl font-bold mb-6 text-center">Projects</h1>
            <Index v-for="project in projects" :project="project"></Index>
    </div>
    <div v-else>
        <h1 class="text-2xl font-bold mb-6 text-center">No projects</h1>
    </div>
    </div>
</template>

<script>
import Index from "../project/Index.vue";
    export default {
        name: "Personal",
        components: {Index},
        data() {
            return {
                projects: [],
                adding: false,
                newProjectName: '',
                newProjectDescription: '',
                errors: []
            }
        },

        mounted() {
            this.loadProjects()
        },

        methods: {
            loadProjects() {
               axios.get('/api/projects')
                .then( res => {
                    this.projects = res.data.data
                })
            },

            createProject() {
                axios.post('/api/projects', {
                    title: this.newProjectName,
                    description: this.newProjectDescription
                })
                .then( res => {
                    this.projects.unshift(res.data.data)
                    this.newProjectName = ''
                    this.newProjectDescription = ''
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
