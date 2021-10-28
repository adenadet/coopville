<template>
<div>
    <FormAdminRepayment :banks="banks" :branches="branches"/>
</div>
</template>

<script>
    const objectToFormData = window.objectToFormData;
    export default {
        data(){
            return {
                branches:[],
                saving_types:[],
                savings:[],
                error: {},
                formData: new Form({
                    import_file:'', 
                    }),
            }
        },
        methods:{
            onFileChange(e) {
                this.import_file = e.target.files[0];
                console.log(this.import_file);
                this.formData.import_file = e.target.files[0];},
            proceedAction() {
                console.log(this.import_file);
                this.formData.import_file = this.import_file;
                this.formData.post('/api/coop/repayments/import', 
                //{headers: { 'content-type': 'multipart/form-data' }}
                )
                    .then(response => {
                        if(response.status === 200) {
                            toast.fire({icon: 'success',title: 'Savings Account Form loaded successfully',});
                        }
                    })
                    .catch(error => {
                        // code here when an upload is not valid
                        this.uploading = false
                        this.error = error.response.data
                    });
                },
            getAllInitials(){
                this.route = ((this.$route.params.id == null) || (this.$route.params.id == ''))? 
                '/api/coop/loans':
                '/api/coop/loans/branch/' + this.$route.params.id;
            
                axios.get(this.route)
                .then(response =>{
                    this.banks = response.data.banks;
                    this.branches = response.data.branches;
                    //Fire.$emit('userFill', this.branches)
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Repayment Initials Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Repayment Initials were not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            let recaptchaScript = document.createElement('script')
            recaptchaScript.setAttribute('src', 'https://cdn.rawgit.com/cretueusebiu/412715093d6e8980e7b176e9de663d97/raw/aea128d8d15d5f9f2d87892fb7d18b5f6953e952/objectToFormData.js')
            document.head.appendChild(recaptchaScript)
            this.getAllInitials();
        }
    }
</script>