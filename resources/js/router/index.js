import {createRouter, createWebHistory} from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/', component: () => import('../views/Index.vue'),
            name: 'home'
        },
        {
            path: '/user/login', component: () => import('../views/user/Login.vue'),
            name: 'user.login'
        },
        {
            path: '/user/registration', component: () => import('../views/user/Registration.vue'),
            name: 'user.registration'
        },
        {
            path: '/user/personal', component: () => import('../views/user/Personal.vue'),
            name: 'user.personal'
        },
        {
            path: '/user/projects/:id/edit', component: () => import('../views/project/Edit.vue'),
            name: 'project.edit'
        },
        {
            path: '/user/projects/:projectId/tasks', component: () => import('../views/tasks/Index.vue'),
            name: 'tasks.index'
        },
        {
            path: '/user/projects/:projectId/tasks/:taskId/edit', component: () => import('../views/tasks/Edit.vue'),
            name: 'tasks.edit'
        },
        {
            path: '/user/statistic', component: () => import('../views/user/Statistic.vue'),
            name: 'user.statistic'
        },
    ]
})


router.beforeEach((to, from, next) => {

    axios.get('/api/user')
        .catch(e => {
            if (e.response.status === 401) {
                localStorage.key('x_xsrf_token') ? localStorage.removeItem('x_xsrf_token') : ''
            }
        })

    const token = localStorage.getItem('x_xsrf_token')

    if (!token) {
        if (to.name === 'user.login' || to.name === 'user.registration') {
            return next()
        } else {
            return next({
                name: 'user.login'
            })
        }
    }

    if (to.name === 'user.login' || to.name === 'user.registration' && token) {
        return next({
            name: 'user.personal'
        })
    }

    next()

})

export default router
