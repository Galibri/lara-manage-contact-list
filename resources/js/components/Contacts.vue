<template>
    <div>
        <h1>Add Contacts</h1>
        <form action="#" @submit.prevent="edit ? updateContact(contact.id) : createContact()">
            <div class="form-group">
                <label>Name</label>
                <input v-model="contact.name" type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input v-model="contact.email" type="text" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input v-model="contact.phone" type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <button v-show="!edit" type="submit" class="btn btn-info">New Contact</button>
                <button v-show="edit" type="submit" class="btn btn-info">Update Contact</button>
            </div>
        </form>
        <h1>Contacts</h1>
        <ul class="list-group">
            <li class="list-group-item" v-for="contact in list">
                {{contact.name}} - {{contact.email}} - {{contact.phone}}
                <button class="btn btn-warning btn-sm" @click="showContact(contact.id)">Edit</button>
                <button class="btn btn-danger btn-sm" @click="deleteContact(contact.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            edit: false,
            list: [],
            contact: {
                id: '',
                name: '',
                email: '',
                phone: ''
            }
        }
    },
    mounted: function() {
        this.fetchContactList();
    },
    methods: {
        fetchContactList: function() {
            axios.get('api/contacts')
                .then((response) => {
                    this.list = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        createContact: function() {
            let self = this;
            let params = Object.assign({}, self.contact);
            axios.post('api/contact/store', params)
                .then(() =>  {
                    self.contact.name = '';
                    self.contact.email = '';
                    self.contact.phone = '';
                    self.edit = false;
                    self.fetchContactList();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showContact: function(id) {
            let self = this;
            axios.get('api/contact/' + id)
                .then( response => {
                    self.contact.id = response.data.id;
                    self.contact.name = response.data.name;
                    self.contact.email = response.data.email;
                    self.contact.phone = response.data.phone;
                })
                self.edit = true;
        },
        updateContact: function(id) {
            let self = this;
            let params = Object.assign({}, self.contact);
            axios.patch('api/contact/' + id, params)
                .then( () =>  {
                    self.contact.name = '';
                    self.contact.email = '';
                    self.contact.phone = '';
                    self.edit = false;
                    self.fetchContactList();
                })
                .catch(error => console.log(error));
        },
        deleteContact: function(id) {
            let self = this;
            axios.delete('api/contact/' + id)
                .then( () => {
                    self.fetchContactList();
                })
                .catch(error => console.log(error));
        }
    }
}
</script>

