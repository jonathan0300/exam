<template>
    <div class="container mt-4">
        <loading :active.sync="isLoading"
        ></loading>


        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Virus Entry Database
                        <button type="button" class="btn btn-primary float-right" @click="openCreate">Add new entry
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table" v-if="viri.length > 0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Tags</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(virus, index) in viri">
                                <td scope="row" v-html="index+1"></td>
                                <td v-html="virus.name"></td>
                                <td><span class="badge m-2 badge-pill badge-primary" v-for="tag in virus.tags"
                                          v-html="tag.title"> </span></td>
                                <td v-html="virus.created_at"></td>
                                <td>
                                    <button type="button" class="btn btn-warning m-2" @click="openUpdate(virus)"> Update</button>
                                    <button type="button" class="btn btn-danger m-2" @click="deleteRow(virus.id)">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <div class="alert alert-primary" role="alert" v-if="viri.length == 0">
                            <strong>No record at the moment.</strong> Please add new entry.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="virus-create" tabindex="-1" role="dialog" aria-labelledby="virus-create"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="store">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add new entry</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="">Name  (required)</label>
                                <input type="text" v-model="form.name" :class="(errors.name) ? 'is-invalid' : ''"
                                       class="form-control form-control-sm" name="" id="" aria-describedby="helpId"
                                       placeholder="">
                                <div class="invalid-feedback" v-if="errors.name">
                                    <span v-html="errors.name[0]"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Enter tags do describe</label>
                                <input-tag placeholder="Enter tags do describe" v-model="form.tags"></input-tag>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="virus-update" tabindex="-1" role="dialog" aria-labelledby="virus-create"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="update">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Entry</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" v-if="selected_row!=null">

                            <div class="form-group">
                                <label for="">Name (required)</label>
                                <input type="text" v-model="selected_row.name" :class="(errors.name) ? 'is-invalid' : ''"
                                       class="form-control form-control-sm" name="" id="" aria-describedby="helpId"
                                       placeholder="">
                                <div class="invalid-feedback" v-if="errors.name">
                                    <span v-html="errors.name[0]"></span>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="">Enter tags do describe</label>
                                <input-tag placeholder="Enter tags do describe" v-model="selected_row.tmp_tags"></input-tag>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import InputTag from 'vue-input-tag'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    data() {
        return {
            form: {
                name: null,
                tags: []
            },
            viri: [],
            selected_row: null,
            isLoading: false,
            errors: [],
        }
    },
    components: {
        InputTag,
        Loading
    },
    methods: {
        load: function () {
            let self = this;
            self.isLoading = true;
            axios.get('/virus')
                .then(function (res) {
                    self.viri = res.data;
                    self.isLoading = false;

                }).catch(function (error) {
                self.isLoading = false;
                alert("Something went wrong. Please refresh the page.")
            })
        },
        openUpdate: function (row) {
            let self = this;
            self.errors = [];
            self.selected_row = row;
            let tags = [];
            row.tags.map(function(item)
            {
                tags.push(item.title);
            });
            self.selected_row.tmp_tags = tags;
            $('#virus-update').modal('show');
        },
        openCreate: function () {
            self.errors = [];
            $('#virus-create').modal('show');
        },
        deleteRow: function (id) {
            let self = this;

            let confirm = window.confirm("Are you sure you want to delete this row?")
            if (confirm) {
                self.isLoading = true;
                axios.delete('/virus/' + id)
                    .then(function (res) {
                        self.isLoading = false;
                        alert("You have successfully deleted this row");
                        self.load();
                    }).catch(function (errors) {
                    self.isLoading = false;
                    alert('Failed to delete. Please try again')
                })

            }
        },
        update: function () {
            let self = this;
            self.isLoading = true;
            axios.put('/virus/'+self.selected_row.id, self.selected_row)
                .then(function (res) {
                    alert('Successfully Updated!')
                    self.isLoading = false;
                    $('#virus-create').modal('hide');
                    setTimeout(function () {
                        self.load();
                    }, 100)
                }).catch(function (errors) {
                alert('Something went wrong. Please check your inputs')
                if (errors.response.data.errors)
                    self.errors = errors.response.data.errors;

                self.isLoading = false;
            })
        },
        store: function () {
            let self = this;
            self.isLoading = true;
            axios.post('/virus', self.form)
                .then(function (res) {
                    alert('Successfully Added!')
                    self.isLoading = false;
                    self.form = {
                        name: null,
                        tags: []
                    }
                    setTimeout(function () {
                        self.load();
                    }, 100)
                }).catch(function (error) {
                alert('Something went wrong. Please check your inputs')
                self.isLoading = false;
            })
        }
    },
    mounted() {
        this.load();
        console.log('Component mounted.')
    }
}
</script>
