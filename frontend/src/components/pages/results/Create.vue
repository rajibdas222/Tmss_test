<template>
    <div>
        <div class="page-title">
            <span>Create Result</span>
        </div>
        <div class="card">
            <div class="card-body">

                <form v-on:submit="create($event)">
                    <div class="form-group">
                        <label for="name">Student id <span class="text-danger">*</span></label>
                        <select v-model="result.student_id" class="form-select form-control" name="student_id" >
                            <option selected>Select Student id</option>
                            <option v-for="st_id in st_lists" :key="st_id"  :value="st_id.id">{{st_id.id}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gpa">GPA <span class="text-danger">*</span></label>
                        <input v-model="result.gpa" type="text" class="form-control" id="gpa" >
                        <small class="form-text text-danger">{{ errors.gpa }}</small>
                    </div>

                    <div class="form-group">
                        <label for="date">Date <span class="text-danger">*</span></label>
                        <input v-model="result.date" type="date" class="form-control" id="date" >
                        <small class="form-text text-danger">{{ errors.date }}</small>
                    </div>

                    <div class="text-center my-3">
                        <button type="button" class="btn btn-default mr-3" @click="$router.push('/results')">Back</button>
                        <button type="submit" class="btn btn-success" :disabled="!isFormValid">Create</button>
                    </div>
                </form>


            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'result-create-page',
        data: function(){
            return {
                result : {
                    gpa : '',
                    date : '',
                    student_id:''
                },
                errors : {
                    gpa : '',
                    date : '',
                    student_id:''
                },
                st_lists:[]
            }
        },

        mounted() {
            const self = this;
            self.axios.get(self.$api_url + '/st_list', self.st_lists, { withCredentials: true,})
                .then(res => {
                    console.log(res);
                    self.st_lists = res.data;
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
            'result.gpa': function(newGpa){
                this.errors.result =  newGpa ? '' : 'GPA is required';
            },
            'result.date': function(newData){
                this.errors.result =  newData ? '' : 'Date is required';
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
        methods : {
            clear: function(){
                this.result = {
                    gpa : '',
                    date : '',
                }
            },
            create: function(e){
                e.preventDefault();
                const self = this;
                if(self.isFormValid == false)
                    return false;

                self.$store.commit('loading', true);
                self.axios.post(self.$api_url + '/results', self.result, { withCredentials: true,})
                    .then(res => {
                        console.log(res);
                        self.$toast.success(res.data.message);
                        self.clear();
                        self.$router.push('/results');
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