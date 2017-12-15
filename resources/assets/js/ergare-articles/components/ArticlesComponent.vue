<template>
    <div>
        <div>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-description">
                Launch Default Modal
            </button>

            <div id="prova" class="editable">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nostrum, tempore. At dolore dolorum ea expedita laudantium nam, numquam officiis repudiandae tenetur totam? Autem debitis, ducimus ea quia quod sapiente.
            </div>

            <div class="modal fade" id="modal-description">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Description</h4>
                        </div>
                        <div class="modal-body">
                            <div id="editor">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nostrum, tempore. At dolore dolorum ea expedita laudantium nam, numquam officiis repudiandae tenetur totam? Autem debitis, ducimus ea quia quod sapiente.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <widget :loading="loading">
            <p slot="title">Articles</p>
            <div v-cloak>

                <table class="table table-bordered table-hover">
                    <tbody><tr>
                        <th style="width: 10px">#</th>
                        <th>Article</th>
                        <th>Read</th>
                        <th>Description</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(article, index) in filteredArticles">
                        <td>{{ index + 1 }}</td>
                        <td>{{ article.title }}</td>
                        <td> <toggle-button :value="true"/> </td>
                        <td class="description"> {{ article.description }} </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="article.created_at" v-text="human(article.created_at)"></a>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="article.updated_at" v-text="human(article.updated_at)"></a>
                        </td>
                        <td>TODO actions here</td>
                    </tr>

                    </tbody></table>

                <ul>
                    <li v-for="article in filteredArticles" :class="{ completed: isCompleted(article) }"
                        @dblclick="editArticle(article)">
                        <input type="text" v-model="newName" id="newName" v-if="article==editedArticle"
                               @keyup.enter="updateArticle(article)" @keyup.esc="cancelEdit(article)">
                        <div v-else>
                            {{article.title}}
                            <i class="fa fa-pencil" aria-hidden="true" @click="editArticle(article)"></i>
                            <i class="fa fa-refresh fa-spin" v-if="article.id === articleBeingDeleted"></i>
                            <i class="fa fa-times" aria-hidden="true" @click="deleteArticle(article)"></i>
                            <i class="fa fa-check" aria-hidden="true" @click="completArticle(article)"></i>
                        </div>
                    </li>
                </ul>
                Articles pendents: {{ pendingArticles }}
                <br>
                <div class="btn-group">
                    <button @click="show('all')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'all' }">All</button>
                    <button @click="show('completed')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'completed' }">Completed</button>
                    <button @click="show('pending')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'pending' }">Pending</button>
                </div>
                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('user_id') }">
                    <label for="user_id">User</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('user_id')" v-if="form.errors.has('user_id')" class="help-block"></span>
                    </transition>
                    <!--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">-->
                    <users @select="userSelected" id="user_id" name="user_id" v-model="form.user_id" :value="form.user_id"></users>
                </div>
                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('name') }">
                    <label for="name">Article name</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('name')" v-if="form.errors.has('name')" class="help-block"></span>
                    </transition>
                    <input @input="form.errors.clear('name')" class="form-control" type="text" v-model="form.name" id="name" name="name" @keyup.enter="addArticle">
                </div>

                <!--aqui al button :disabled he llevat la opció de que es deshabilite si hi ha erros, ja que si sel·lecciones l'usuari desprès de que et salte l'error, el botó no s'habilita-->
                <button :disabled="form.submitting" id="add" @click="addArticle" class="btn btn-primary">
                    <i class="fa fa-refresh fa-spin fa-lg" v-if="form.submitting"></i>
                    Afegir
                </button>
            </div>
            <p slot="Footer">Footer</p>
        </widget>

        <message title="Message" message="" color="info"></message>
    </div>
</template>

<style src="quill/dist/quill.snow.css"></style>

<style src="medium-editor/dist/css/medium-editor.min.css"></style>
<style src="medium-editor/dist/css/themes/default.min.css"></style>


<style>
    .description {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    li.completed {
        text-decoration : line-through;
    }

    [v-cloak] { display: none; }

    li.active {
        background-color: blue;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity 3s ease;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>

<script>

    import Users from './Users'
    import Form from 'acacha-forms'
    import Quill from 'quill'
    import MediumEditor from 'medium-editor'

    var filters = {
    all: function (articles) {
      return articles
    },
    pending: function (articles) {
      return articles.filter(function (article) {
        return !article.completed
      })
    },
    completed: function (articles) {
      return articles.filter(function (article) {
        return article.completed
      })
    }
  }

    import { wait } from './utils.js'
    import moment from 'moment'
    import {config} from '../config/articles.js'

  const API_URL = '/api/v1/articles/'

  export default {
    components: {Users},
    data () {
      return {
        loading: false,
        editedArticle: null,
        filter: 'all',
        newName: '',
        name: '',
        articles: [],
        creating: false,
          articleBeingDeleted: null,
        form: new Form({user_id:'',name:''})
      }
    },
    computed: {
      // a computed getter
      filteredArticles () {
        return filters[this.filter](this.articles)
      },
      pendingArticles () {
        return filters['pending'](this.articles).length
      }
    },
    watch: {
      articles: function () {
//                localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(this.articles))
      }
    },
    methods: {
        human(date) {
            return moment(date).fromNow()
        },
      userSelected(user) {
        this.form.user_id = user.id
      },
      show (filter) {
        this.filter = filter
      },
      addArticle () {
        this.$emit('loading', true)
        this.creating = true
        this.form.post(API_URL).then((response) => {
          this.articles.push({name: this.form.name, user_id: this.form.user_id, completed: false})
          this.form.name = ''
//        }).catch((error) => {
//          flash(error.message)
        }).then(() => {
          this.creating = false
          this.$emit('loading', false)
        })
      },
      isCompleted (article) {
        return article.completed
      },
      deleteArticle (article) {
        this.$emit('loading', true)
        this.articleBeingDeleted = article.id
        axios.delete(API_URL + article.id).then((response) => {
          this.articles.splice(this.articles.indexOf(article), 1)
//        }).catch((error) => {
//          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        }).then(
          this.articleBeingDeleted = null
        )
      },
      updateArticle (article) {
        this.$emit('loading', true)
        axios.get(API_URL+article.id).then((response) =>  {
//          this.articles[this.articles.indexOf(article)].name = this.newName;
//          this.newName = ''
//          this.editedArticle = null
//        }).catch((error) => {
//          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      editArticle (article) {
        this.editedArticle = article
        this.newName = article.name
      },
      cancelEdit (article) {
          this.editedArticle = null
      }
    },
    mounted () {

        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        new MediumEditor('.editable');


        console.log(this.articles)

      // HTTP CLIENT
      //Promises
      this.$emit('loading', true)
      axios.get(API_URL).then((response) => {
        this.articles = response.data
      }).catch((error) => {
        console.log(error)
        flash(error.message)
      }).then(() => {
        this.$emit('loading', false)
      })

//            setTimeout( () => {
//                component.hide()
//            },3000)

      // API HTTP amb JSON <- Web service
      // URL GET http://NOM_SERVIDOR/api/articles
      // URL POST http://NOM_SERVIDOR/api/articles
      // URL DELETE http://NOM_SERVIDOR/api/articles/{article}
      // URL PUT/PATCH http://NOM_SERVIDOR/api/articles/{article}
    }
  }
</script>
