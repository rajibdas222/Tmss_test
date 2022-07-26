<template>
    <div>
        <div class="page-title">
            <span>Create Student</span>
        </div>
        <div class="card">
            <div class="card-body">

                <form v-on:submit="create($event)">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input v-model="student.name" type="text" class="form-control" id="name" >
                        <small class="form-text text-danger">{{ errors.name }}</small>
                    </div>

                    <div class="form-group">
                        <label for="name">Department select <span class="text-danger">*</span></label>
                        <select v-model="student.department_id" class="form-select form-control" name="department_id" >
                            <option selected>Select department</option>
                            <option v-for="dept in dept_lists" :key="dept"  :value="dept.id">{{dept.name}}</option>
                        </select>


                    </div>

                    <div class="form-group">
                        <label for="batch_name">Batch Name <span class="text-danger">*</span></label>
                        <input v-model="student.batch_name" type="text" class="form-control" id="batch_name" >
                        <small class="form-text text-danger">{{ errors.batch_name }}</small>
                    </div>

                    <div class="text-center my-3">
                        <button type="button" class="btn btn-default mr-3" @click="$router.push('/students')">Back</button>
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
                student : {
                    name : '',
                    batch_name : '',
                    department_id:''
                },
                errors : {
                    name : '',
                    batch_name : '',
                    department_id:''
                },
                dept_lists:[]
            }
        },

        mounted() {
            const self = this;
            self.axios.get(self.$api_url + '/dept_list', self.dept_lists, { withCredentials: true,})
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

        watch:{
            'student.name': function(newName){
                this.errors.student =  newName ? '' : 'Name is required';
            },

        },
        computed:{
            isFormValid: function(){
                let valid = true;
                const self = this;
                for (const [key, value] of Object.entries(self.errors)) {
                    if(self.student[key] == '' || value != ''){
                        valid = false;
                        break;
                    }
                }
                return valid;
            }
        },
        methods : {
            clear: function(){
                this.student = {
                    name : '',
                    batch_name : '',
                }
            },
            create: function(e){
                e.preventDefault();
                const self = this;
                if(self.isFormValid == false)
                    return false;

                self.$store.commit('loading', true);
                self.axios.post(self.$api_url + '/students', self.student, { withCredentials: true,})
                    .then(res => {
                        console.log(res);
                        self.$toast.success(res.data.message);
                        self.clear();
                        self.$router.push('/students');
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