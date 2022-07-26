<template>
    <div>
        <div class="page-title">
            <span>Edit Result</span>
        </div>

        <div class="card">
            <div class="card-body">

                <form v-on:submit="update($event, $route.params.id)">

                </form>


            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'department-update-page',
        data: function(){
            return {
                result : {
                    name : '',
                    batch_name : '',
                    department_id:''
                },
                errors : {
                    name : '',
                    batch_name : '',
                    department_id:''
                },
                st_lists:null,
            }
        },
        watch:{
            'student.name': function(newName){
                this.errors.name =  newName ? '' : 'Name is required';
            },

            'student.batch_name': function(newBatchname){
                this.errors.name =  newBatchname ? '' : 'Batch Name is required';
            },

        },
        computed:{
            isFormValid: function(){
                let valid = true;
                const self = this;
                for (const [key, value] of Object.entries(self.errors)) {
                    if(self.result[key] == '' || value != ''){
                        valid = false;
                        break;
                    }
                }
                return valid;
            }
        },
        mounted: function() {
            this.show(this.$route.params.id);

            const self = this;
            self.axios.get(self.$api_url + '/st_list', self.st_lists, { withCredentials: true,})
                .then(res => {
                    console.log(res);
                    self.dept_lists = res.data;
                })
                .catch(err => {
                    const message = err.response.data.message ? err.response.data.message : err.message;
                    self.$toast.error(message);
                })
                .finally(() => {
                    self.$store.commit('loading', false);
                });
        },
        methods : {

            show: function(id){
                const self = this;
                self.$store.commit('loading', true);
                self.axios.get(self.$api_url + '/results/'+id+'/show', { withCredentials: true,})
                    .then(res => {
                        self.result = res.data;
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                        self.$router.push('/results');
                    })
                    .finally(() => {
                        self.$store.commit('loading', false);
                    });
            },

            update: function(e, id){
                e.preventDefault();
                const self = this;
                if(self.isFormValid == false)
                    return false;

                self.$store.commit('loading', true);
                self.axios.put(self.$api_url + '/results/' + id + '/update', self.result, { withCredentials: true,})
                    .then(res => {
                        console.log(res);
                        self.$toast.success(res.data.message);
                        self.$router.push('/results');
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                        self.$router.push('/results');
                    })
                    .finally(() => {
                        self.$store.commit('loading', false);
                    });
            }

        }
    }
</script>