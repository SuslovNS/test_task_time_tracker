<!--<template>-->
<!--    <div >-->
<!--        <div class="mb-6 text-center">-->
<!--            <div class="flex-grow">-->
<!--                <label for="project-name" class="block text-gray-700 font-bold mb-2">Project Name</label>-->
<!--                <input type="text" id="project-name" v-model="project.title"-->
<!--                       class="w-96  rounded-3xl border p-2 border-slate-400"-->
<!--                       required>-->
<!--            </div>-->
<!--            <div v-if="errors.title">-->
<!--                <p v-for="error in errors.title" class="text-sm mt-2 text-red-500">{{error}}</p>-->
<!--            </div>-->
<!--            <div class="flex-grow">-->
<!--                <label for="project-description" class="block text-gray-700 font-bold mb-2">Project Description</label>-->
<!--                <input type="text" id="project-description" v-model="project.description"-->
<!--                       class="w-96  rounded-3xl border p-2 border-slate-400"-->
<!--                       required>-->
<!--            </div>-->
<!--            <div v-if="errors.description">-->
<!--                <p v-for="error in errors.description" class="text-sm mt-2 text-red-500">{{error}}</p>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div>-->
<!--            <a @click.prevent="editProject(project)" href="#" class="block p-2 w-32 text-center rounded-3xl bg-red-600 text-white-->
<!--            hover:bg-white hover:border hover:border-red-600 hover:text-red-600 ml-auto">Edit</a>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<template>
    <div class="max-w-lg mx-auto mt-8 bg-white shadow-md rounded-lg overflow-hidden">
        <div class="py-4 px-6">
            <h2 class="text-2xl font-bold mb-4">Edit Project</h2>
            <form>
                <div class="mb-4">
                    <label for="project-name" class="block text-gray-700 font-bold mb-2">Project Name</label>
                    <input
                        type="text"
                        id="project-name"
                        v-model="project.title"
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
                        v-model="project.description"
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
                        @click.prevent="editProject(project)"
                        class="px-4 py-2 rounded-lg bg-indigo-500 text-white hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600"
                    >
                        Edit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Edit",

        data () {
            return {
                projId: this.$route.params.id,
                project: [],
                errors: [],
            }
        },

        mounted() {
            this.loadProject()
        },

        methods: {
            loadProject() {
                axios.get(`/api/projects/${this.projId}`)
                .then( res => {
                    this.project = res.data.data
                })
            },

            editProject(project) {
                axios.patch(`/api/projects/${this.projId}/update`, {
                    title: this.project.title,
                    description: this.project.description
                })
                    .then( res => {
                        this.$router.push({name: 'user.personal'})
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
