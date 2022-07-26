<template>
    <div>
        <div class="page-title">
            <span>All Students</span>
        </div>

        <div class="row d-flex justify-content-between mb-2">
            <div class="col-sm-6">
                <input class="form-control" type="text" placeholder="search" aria-label="default input example">
            </div>

            <div class="col-sm-2">
                <router-link :to="{ name: 'student.create' }" class="btn btn-primary">Create Student</router-link>
            </div>
        </div>



        <div v-if="students.length == 0" class="card">
            <div class="card-body">
                <p>No Student are found !!</p>
            </div>
        </div>

        <table v-if="students.length" class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Department ID</th>
                <th scope="col">Batch Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(student, index) in students" v-bind:key="index">
                <th scope="row">{{ student.id }}</th>
                <td>{{ student.name}}</td>
                <td>{{ student.department_id}}</td>
                <td>{{ student.batch_name}}</td>
                <td>
                    <button @click="$router.push('/students/'+student.id+'/update')" class="btn btn-warning btn-sm mr-2">Edit</button>
                    <button @click="deletePost(student.id, index)" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>



            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "student-list-page",

        data: function(){
            return {
                students : [],
            }
        },

        mounted : function(){
            this.getPosts();
        },

        methods : {
            getPosts: function(){
                const self = this;
                self.$store.commit('loading', true);

                self.axios.get(self.$api_url + '/students', { withCredentials: true,})
                    .then(res => {
                        self.students = res.data;
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
                self.axios.delete(self.$api_url + '/students/' + id + '/delete', { withCredentials: true,})
                    .then(res => {
                        self.$toast.success(res.data.message);
                        self.students.splice(index,1);
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