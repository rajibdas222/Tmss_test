<template>
    <div>
        <div class="page-title">
            <span>All Results</span>
        </div>

        <div v-if="results.length == 0" class="card">
            <div class="card-body">
                <p>No Result are found !!</p>
            </div>
        </div>

        <div class="row d-flex justify-content-between mb-2">
            <div class="col-sm-6">
                <input class="form-control" type="text" name="search" placeholder="Search result" aria-label="default input example">
            </div>

            <div class="col-sm-2">
                <router-link :to="{ name: 'results.create' }" class="btn btn-primary">Create Result</router-link>
            </div>
        </div>

        <table v-if="results.length" class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Student ID</th>
                <th scope="col">Name</th>
                <th scope="col">GPA </th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(result, index) in results" v-bind:key="index">

                <th scope="row">{{ index+1 }}</th>
                <td>{{ result.student_id }}</td>
                <td>{{ result.student.name }}</td>
                <td>{{ result.gpa}}</td>
                <td>{{ format_date(result.date)}}</td>
                <td>
                    <button @click="$router.push('/results/'+result.id+'/update')" class="btn btn-warning btn-sm mr-2">Edit</button>
                    <button @click="deletePost(result.id, index)" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>

            </tbody>
        </table>

    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "result-list-page",

        data: function(){
            return {
                results : [],
            }
        },

        mounted : function(){
            this.getPosts();
        },

        methods : {
            getPosts: function(){
                const self = this;
                self.$store.commit('loading', true);

                self.axios.get(self.$api_url + '/results', { withCredentials: true,})
                    .then(res => {
                        console.log(res);
                        self.results = res.data;
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
                self.axios.delete(self.$api_url + '/results/' + id + '/delete', { withCredentials: true,})
                    .then(res => {
                        console.log(res);
                        self.$toast.success(res.data.message);
                        self.results.splice(index,1);
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                    })
                    .finally(() => {
                        self.$store.commit('loading', false);
                    });
            },
            format_date(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            },
        }
    }


</script>

<style scoped>

</style>