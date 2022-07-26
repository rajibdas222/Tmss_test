<template>
    <div>
        <div class="page-title">
            <span>Create Department</span>
        </div>
        <div class="card">
            <div class="card-body">

                <form v-on:submit="create($event)">
                    <div class="form-group">
                        <label for="name">Department Name <span class="text-danger">*</span></label>
                        <input v-model="department.name" type="text" class="form-control" id="name" >
                        <small class="form-text text-danger">{{ errors.name }}</small>
                    </div>

                    <div class="text-center my-3">
                        <button type="button" class="btn btn-default mr-3" @click="$router.push('/departments')">Back</button>
                        <button type="submit" class="btn btn-success" :disabled="!isFormValid">Create</button>
                    </div>
                </form>


            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'department-create-page',
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
                this.errors.title =  newName ? '' : 'Name is required';
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
        methods : {
            clear: function(){
                this.department = {
                    name : '',
                }
            },
            create: function(e){
                e.preventDefault();
                const self = this;
                if(self.isFormValid == false)
                    return false;

                self.$store.commit('loading', true);
                self.axios.post(self.$api_url + '/departments', self.department, { withCredentials: true,})
                    .then(res => {
                        self.$toast.success(res.data.message);
                        self.clear();
                        self.$router.push('/departments');
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