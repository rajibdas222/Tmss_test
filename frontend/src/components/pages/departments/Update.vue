<template>
    <div>
        <div class="page-title">
            <span>Edit Department</span>
        </div>

        <div class="card">
            <div class="card-body">

                <form v-on:submit="update($event, $route.params.id)">
                    <div class="form-group">
                        <label for="department">Department <span class="text-danger">*</span></label>
                        <input v-model="department.name"  type="text" class="form-control" id="department">
                        <small class="form-text text-danger">{{ errors.name }}</small>
                    </div>
                    <div class="text-center my-3">
                        <button type="button" class="btn btn-default mr-3" @click="$router.push('/departments')">Back</button>
                        <button type="submit" class="btn btn-success" :disabled="!isFormValid">Update</button>
                    </div>
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
                department : {
                    name : '',
                },
                errors : {
                    name : '',
                },
            }
        },
        watch:{
            'department.name': function(newName){
                this.errors.name =  newName ? '' : 'Name is required';
            },

        },
        computed:{
            isFormValid: function(){
                let valid = true;
                const self = this;
                for (const [key, value] of Object.entries(self.errors)) {
                    if(self.department[key] == '' || value != ''){
                        valid = false;
                        break;
                    }
                }
                return valid;
            }
        },
        mounted: function() {
            this.show(this.$route.params.id);
        },
        methods : {

            show: function(id){
                const self = this;
                self.$store.commit('loading', true);
                self.axios.get(self.$api_url + '/departments/'+id+'/show', { withCredentials: true,})
                    .then(res => {
                        self.department = res.data;
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                        self.$router.push('/departments');
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
                self.axios.put(self.$api_url + '/departments/' + id + '/update', self.department, { withCredentials: true,})
                    .then(res => {
                        console.log(res);
                        self.$toast.success(res.data.message);
                        self.$router.push('/departments');
                    })
                    .catch(err => {
                        const message = err.response.data.message ? err.response.data.message : err.message;
                        self.$toast.error(message);
                        self.$router.push('/departments');
                    })
                    .finally(() => {
                        self.$store.commit('loading', false);
                    });
            }

        }
    }
</script>