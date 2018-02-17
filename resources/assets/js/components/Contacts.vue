<!-- vue component -->
<template>
    <div>
        <h1>contact vue component</h1>

        <form action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()">

            <div class="form-group">
                <label>Name</label>
                <input v-model="contact.name" type="text" name="name" class="form-control">
            </div>

            <div class="form-group">
                <label>email</label>
                <input v-model="contact.email" type="text" name="email" class="form-control">
            </div>

            <div class="form-group">
                <label>phone</label>
                <input v-model="contact.phone" type="text" name="phone" class="form-control">
            </div>


            <div class="form-group">
                <button v-show="!edit" type="submit" class="btn btn-primary">New Contact </button>
                <button v-show="edit" type="submit" class="btn btn-primary">Update Contact </button>
            </div>

        </form>

        <h1> contacts </h1>
        <ul class="list-group">
            <li class="list-group-item" v-for="contact in list" >
                {{contact.name}} | {{contact.email}} | {{contact.phone}}
             </li>

             <button @click="showContact(contact.id)" class="btn btn-default btn-xs">edit </button>

             <button @click="deleteContact(contact.id)" class="btn btn-danger btn-xs">Delete </button>
        </ul>

    </div>
</template>

<script>
    export default {

        data(){
            return{
                edit:false,
                list:[],
                contact:{
                    id:'',
                    name:'',
                    email:'',
                    phone:''
                }
            }
        },
        mounted() {
            console.log('Contacts Component mounted.');
            this.fetchContactList();
        },
        methods:{

            fetchContactList:function(){
                console.log('fetchContactList');

                axios.get('api/contacts')
                    .then((response)=>{
                        this.list=response.data;
                        console.log(response.data);
                })
                .catch((error)=>{
                    console.log(error);
                });
            },
            createContact: function(){
                console.log('Contacts create Component mounted.');

                let self=this;
                let params=Object.assign({},self.contact);

                axios.post('api/contact/store',params)
                    .then(function(){
                        self.contact.name='';
                        self.contact.email='';
                        self.contact.phone='';
                        self.edit=false;
                        self.fetchContactList();
                    })
                    .catch(function (error){
                        console.log(error);
                    });
            },
            updateContact: function(id){
                console.log('update id '+id);
            },

            showContact(id){
                let self=this;
                axios.get('api/contact/'+id)
                    .then(function (response){

                        //assign data
                        self.contact.id=response.data.id;
                        self.contact.name=response.data.name;
                        self.contact.email=response.data.email;
                        self.contact.phone=response.data.phone;
                    })
                    self.edit=true;
            }
        }
    }
</script>