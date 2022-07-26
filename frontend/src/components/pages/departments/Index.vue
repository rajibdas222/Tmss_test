<template>
    <div>
        <div class="page-title">
            <span>All Department</span>
        </div>
        <div class="text-right">
            <div class="text-right mb-1">
                <router-link :to="{ name: 'department.create' }" class="btn btn-primary">Create Department</router-link>
            </div>
        </div>
        <div v-if="departments.length == 0" class="card">
            <div class="card-body">
                <p>No Department are found !!</p>
            </div>
        </div>

        <table v-if="departments.length" class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(department, index) in departments" v-bind:key="index">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ department.name }}</td>
                <td>
                    <button @click="$router.push('/department/'+department.id+'/update')" class="btn btn-warning btn-sm mr-2">Edit</button>
                    <button @click="deletePost(department.id, index)" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "department-list-page",

        data: function(){
            return {
                departments : [],
            }
        },

        mounted : function(){
            this.getPosts();
        },

        methods : {
            getPosts: function(){
                const self = this;
                self.$store.commit('loading', true);

                self.axios.get(self.$api_url + '/departments', { withCredentials: true,})
                    .then(res => {
                        self.departments = res.data;
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                    })
                    .finally(() => {
                        self.$store.commit('loading', false);
                    });
            },
            deletePost: function(id, index){
                if(confirm("Are you sure to delete operation?") === false)
                    return;

                const self = this;
                self.$store.commit('loading', true);
                self.axios.delete(self.$api_url + '/departments/' + id + '/delete', { withCredentials: true,})
                    .then(res => {
                        self.$toast.success(res.data.message);
                        self.departments.splice(index,1);
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                    })
                    .finally(() => {
                        self.$store.commit('loading', false);
                    });
            }
        }
    }


</script>

<style scoped>

</style>