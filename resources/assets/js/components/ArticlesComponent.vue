<template>
    <div>
        <widget :loading="loading">
            <button type="button" class="btn btn-success" @click="setEditorRadioButtonChecked()" data-backdrop="static" data-toggle="modal" data-target="#modal-options"><span class="glyphicon glyphicon-cog"></span></button>
            <button type="button" class="btn btn-warning" id="reload" @click="reloadPage()">Reload page</button>
            <div class="modal fade" id="modal-options">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Editor per a la descripció:</h2>
                        </div>
                        <div class="modal-body">
                            <form>
                                <input id="quillRadioButton" type="radio" name="editorSelected" value="quill">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 942 559.9" width="52px" height="31px">
                                    <circle cx="749" cy="125.5" r="25.7" class="logo"></circle>
                                    <path d="M643.3 211.5c0 21.2 0 76.5 0 91.8 0 19.5-3.5 90.9-76.1 90.9-75.9 0-74.3-71.3-74.3-98.8 0-23.4 0-70.4 0-83.8h-39v94.1s-8.1 128.5 111.3 128.5c119.4 0 115.4-124.5 115.4-124.5v-98.2h-37.3zM816.5 45.2H855v378.5h-38.5zM504 472.7c-79.4 0-194.9-12-268.3-12.8-12.2 0-23 1.5-32.6 3.9l13-11.6c14.3-12.9 37.6-20.9 43.4-22 94.4-18.6 164.8-93.7 164.8-212.8C424.3 83.2 329.3 0 212.1 0S0 76.9 0 217.3c0 126.8 84.9 208 193.1 216.5 0 0 5.7.1 6.4 3.6.6 3.1-4.8 7.6-4.8 7.6l-64.4 59.6 12.4 13.4 23.8-21.3c13.3-10.6 35.1-23.6 62.1-23.6 89.3 0 188.2 89.1 280.1 86.9 134.4-3.2 165.7-93 169.1-104.6.2-.4-55.6 17.3-173.8 17.3zM39.4 217.3c0-114.3 77.3-177 172.8-177 95.4 0 172.8 67.7 172.8 177 0 112.6-77.3 177-172.8 177-95.5-.1-172.8-67.8-172.8-177zM903.5 45.2H942v378.5h-38.5zM729.5 211.1H768v212.5h-38.5z" class="logo"></path>
                                </svg>
                                <p style="clear:none; font-size: 1em;"><input id="medium-editorRadioButton" type="radio" name="editorSelected" value="medium-editor">
                                    <strong>Medium<span style="color: #FFAA37;">Editor</span></strong><br></p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p>Actual: <svg v-if="editor == 'quill'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 942 559.9" width="52px" height="31px">
                                <circle cx="749" cy="125.5" r="25.7" class="logo"></circle>
                                <path d="M643.3 211.5c0 21.2 0 76.5 0 91.8 0 19.5-3.5 90.9-76.1 90.9-75.9 0-74.3-71.3-74.3-98.8 0-23.4 0-70.4 0-83.8h-39v94.1s-8.1 128.5 111.3 128.5c119.4 0 115.4-124.5 115.4-124.5v-98.2h-37.3zM816.5 45.2H855v378.5h-38.5zM504 472.7c-79.4 0-194.9-12-268.3-12.8-12.2 0-23 1.5-32.6 3.9l13-11.6c14.3-12.9 37.6-20.9 43.4-22 94.4-18.6 164.8-93.7 164.8-212.8C424.3 83.2 329.3 0 212.1 0S0 76.9 0 217.3c0 126.8 84.9 208 193.1 216.5 0 0 5.7.1 6.4 3.6.6 3.1-4.8 7.6-4.8 7.6l-64.4 59.6 12.4 13.4 23.8-21.3c13.3-10.6 35.1-23.6 62.1-23.6 89.3 0 188.2 89.1 280.1 86.9 134.4-3.2 165.7-93 169.1-104.6.2-.4-55.6 17.3-173.8 17.3zM39.4 217.3c0-114.3 77.3-177 172.8-177 95.4 0 172.8 67.7 172.8 177 0 112.6-77.3 177-172.8 177-95.5-.1-172.8-67.8-172.8-177zM903.5 45.2H942v378.5h-38.5zM729.5 211.1H768v212.5h-38.5z" class="logo"></path>
                            </svg>
                                <strong v-else-if="editor == 'medium-editor'">Medium<span style="color: #FFAA37;">Editor</span></strong><br>
                            </p>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" @click="updateEditor()" class="btn btn-primary" data-dismiss="modal">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <p slot="title">Articles Vue</p>
            <div v-cloak>
                <table id="article-table" class="table table-bordered table-hover">
                    <tbody><tr>
                        <th>#</th>
                        <th>Id Article</th>
                        <th>Article</th>
                        <th>Read</th>
                        <th>Description</th>
                        <th>User name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(article, index) in filteredArticles" v-bind:class="{read: article.read}">
                        <td><b>{{ index + 1 }}</b></td>
                        <td>{{ article.id }}</td>
                        <td>
                            <div>
                                <input type="text" v-model="newTitle" id="newTitle" v-if="article==editedArticle"
                                       @keyup.enter="updateTitleArticle(article)" @keyup.esc="cancelEdit(article)">
                                <div v-else v-bind:id="'name-'+article.id" @dblclick="editArticleName(article)">
                                    {{article.title}}
                                </div>
                            </div>
                        <td>
                            <toggle-button :sync="true" @change="article.read?readArticle(article):unreadArticle(article)" v-model="article.read"/>
                        </td>
                        <td>
                            <div v-if="editor == 'quill'">
                                <button type="button" class="btn btn-warning" data-backdrop="static" data-toggle="modal" data-target="#modal-description" @click="editArticleDescription(article)"><span class="fa fa-pencil"></span></button>
                                <button type="button" class="btn btn-success" @click="updateArticleBox(article,'description'); changeEyeIcon('eye-description-'+article.id);"><span v-bind:id="'eye-description-'+article.id" class="glyphicon glyphicon-eye-open"></span></button>
                                <p class="description" v-bind:id="'description-'+article.id" v-html="article.description"></p>

                                <div class="modal fade" id="modal-description">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" @click="cancelEdit()" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Id Article: {{editedArticle}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <quill-editor ref="myTextEditor" @change="updateNewTextQuill($event.html,'description')" :content=quillText v-bind:id="'description-'+article.id">
                                                </quill-editor>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" @click="cancelEdit()" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button type="button" @click="updateArticleBox(article,'description',true); updateDescriptionArticle(article);cancelEdit();" class="btn btn-primary" data-dismiss="modal">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <medium-editor v-bind:id="'description-'+article.id" v-else-if="editor == 'medium-editor'" class="description" :text='article.description' v-on:edit='updateDescriptionArticle(article)'></medium-editor>
                        </td>
                        <td>
                            {{ showUserName(article) }}
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="article.created_at" v-text="human(article.created_at)"></a>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="article.updated_at" v-text="human(article.updated_at)"></a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" data-backdrop="static" data-toggle="modal" data-target="#modal-article" @click="showArticle(article)"><span class="glyphicon glyphicon-search"></span></button>
                            <button :id="'delete-article-'+article.id" type="button" class="btn btn-danger" data-backdrop="static" data-toggle="modal" data-target="#modal-article" @click="showArticleToDelete(article)"><span class="fa fa-trash-o"></span></button>

                            <div class="modal fade" id="modal-article">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 v-if="deleting">Esteu segur de borrar aquesta tasca? </h2>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Id: {{ showedArticle.id }}</li>
                                                <li>Name: {{ showedArticle.name }}</li>
                                                <li id="show-description">Description: </li>
                                                <li>Read: {{ showedArticle.read?'Yes':'No' }}</li>
                                                <li>User_id: {{ showedArticle.user_id }}</li>
                                                <li>User name: {{ showedArticleUserName }}</li>
                                                <li>Created at: {{ human(showedArticle.created_at) }}, {{ showedArticle.created_at }}</li>
                                                <li>Updated at: {{ human(showedArticle.updated_at) }}, {{ showedArticle.updated_at }}</li>
                                            </ul>

                                        </div>
                                        <div class="modal-footer">
                                            <div v-if="!deleting">
                                                <button @click="cancelShow()" type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button v-if="getArticlePos(showedArticle)!=0" type="button" @click="showArticle(afterBeforeArticle(false))"><span><</span></button>
                                                <button v-if="!isLastArticleFiltered(showedArticle)"type="button" @click="showArticle(afterBeforeArticle(true))"><span>></span></button>
                                            </div>
                                            <div v-else="!deleting">
                                                <button id="cancel-delete-article" @click="cancelShow()" type="button" class="btn btn-success pull-left" data-dismiss="modal">NO</button>
                                                <button id="destroy-article" class="btn btn-danger" type="button" @click="deleteArticle(showedArticle);cancelShow()"><span>SI</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody></table>

                Articles pendents: {{ pendingArticles }} <br>
                Articles filtrats: {{ filteredArticles.length }}
                <br>
                <div class="btn-group">
                    <button @click="show('all')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'all' }">All</button>
                    <button id="read-articles" @click="show('read')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'read' }">Read</button>
                    <button id="pending-articles" @click="show('pending')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'pending' }">Pending</button>
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

                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('description') }">
                    <label for="description">Article description</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('description')" v-if="form.errors.has('description')" class="help-block"></span>
                    </transition>
                    <quill-editor v-if="editor == 'quill'" v-model="form.description" id="description" name="description" @input="form.errors.clear('description')" ref="myTextEditor" @change="updateNewTextQuill($event.html,'description')" :content=quillText>
                    </quill-editor>
                    <medium-editor v-model="form.description" id="description" name="description" @input="form.errors.clear('description')" v-else-if="editor == 'medium-editor'" class="description" text="<i>Insert text here ...<i>"></medium-editor>
                    <!--<input @input="form.errors.clear('description')" class="form-control" type="text" v-model="form.description" id="description" name="description" @keyup.enter="addArticle">-->
                </div>

                <!--aqui al button :disabled he llevat la opció de que es deshabilite si hi ha erros, ja que si sel·lecciones l'usuari desprès de que et salte l'error, el botó no s'habilita-->
                <button :disabled="form.submitting" id="store-article" @click="addArticle" class="btn btn-primary">
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
    [v-cloak] {
        display: none;
    }
    li.read {
        text-decoration: line-through;
    }
    .description{
        max-width: 500px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<script>

  import Users from './Users'
  import Form from 'acacha-forms'
  import Quill from 'quill'
  import { quillEditor } from 'vue-quill-editor'
  import MediumEditor from 'medium-editor'
  import editor from 'vue2-medium-editor'

  var filters = {
    all: function (articles) {
      return articles
    },
    pending: function (articles) {
      return articles.filter(function (article) {
        return !article.read
      })
    },
    read: function (articles) {
      return articles.filter(function (article) {
        return article.read
      })
    }
  }

  import { wait } from './utils.js'
  import moment from 'moment'
  import {config} from '../config/articles.js'

  const API_URL = '/api/v1/'
  const API_ARTICLES_URL = API_URL+'articles/'

  import createApiArticle from './articles/api/articles';
  import createApiDescriptionArticle from './articles/api/descriptionArticles';
  import createApiReadArticle from './articles/api/readArticles';
  import createApiUsers from './articles/api/users';

  const crudArticle = createApiArticle(API_ARTICLES_URL);
  const crudArticleDescription = createApiDescriptionArticle(API_URL+'description-article/');
  const crudArticleRead = createApiReadArticle(API_URL+'read-article/');
  const crudUsers = createApiUsers(API_URL+'users/');

  export default {
    components: {Users,'medium-editor': editor,quillEditor},
    data () {
      return {
        showedArticle:'',
        showedArticleUserName:'',
        quillText: '',
        loading: false,
        editedArticle: null,
        filter: 'all',
        newTitle: '',
        newDescription: '',
        name: '',
        articles: [],
        users: [],
        creating: false,
        deleting: false,
        articleBeingDeleted: null,
        form: new Form({user_id:'',name:'',description:''})
      }
    },
    computed: {
      editor() {
        if (localStorage.getItem('editor') == null){
          localStorage.setItem('editor',config.editor)
        }
        return localStorage.getItem('editor')
      },
      readFilter() {
        return this.filter==='read'
      },
      filteredArticles () {
        return filters[this.filter](this.articles)
      },
      pendingArticles () {
        return filters['pending'](this.articles).length
      },
    },
    methods: {
      human(date) {
        return moment(date).fromNow()
      },
      userSelected(user) {
        this.form.user_id = user.id
      },
      show(filter) {
        this.filter = filter
      },
      setEditorRadioButtonChecked(){
        document.getElementById(localStorage.getItem('editor')+"RadioButton").setAttribute("checked",true)
      },
      updateEditor(){
        var radios = document.getElementsByName('editorSelected');

        for (var i = 0, length = radios.length; i < length; i++)
        {
          if (radios[i].checked)
          {
            console.log(localStorage.getItem('editor'))
            localStorage.setItem('editor', radios[i].value)
            window.location.reload()
            break
          }
        }
      },
      reloadPage(){
        window.location.reload()
      },
      isLastArticleFiltered(article){
        var length = this.filteredArticles.length

        return this.getArticlePos(article)+1 == length
      },
      getArticlePos(article){
        for (var i = 0; i < this.filteredArticles.length; i++) {
          if (this.filteredArticles[i] == article){
            return i
          }
        }
      },
      afterBeforeArticle(after){
        var op
        if (after) {
          op = 1
        } else {
          op = -1
        }
        for (var i = 0; i < this.filteredArticles.length; i++) {
          if (this.filteredArticles[i] == this.showedArticle){
            return this.filteredArticles[i+op]
          }
        }
      },
      changeEyeIcon(id){

        var eyesOpen = false

        if (document.getElementById(id).getAttribute("class") == 'glyphicon glyphicon-eye-open'){
          eyesOpen = true
        }

        if (eyesOpen) {
          document.getElementById(id).setAttribute("class","glyphicon glyphicon-eye-close")
        } else {
          document.getElementById(id).setAttribute("class","glyphicon glyphicon-eye-open")
        }
      },
      cancelEdit(){
        this.editedArticle = null
        this.newDescription = null
        this.newTitle = null
        this.quillText = null
      },
      updateArticleBox(article,property,editedFinal){
        if (property == 'name'){
          this.quillText = this.newTitle
        } else if (property == 'description'){
          this.quillText = this.newDescription
        }
        var idArticle
        if (!this.editedArticle){
          idArticle = article.id
        } else {
          idArticle = this.editedArticle
        }
        var textBox
        this.filteredArticles.filter(function(article){
          if (article.id == idArticle){
            textBox = article[property]
          }
        })

        if(editedFinal){
          if (textBox.startsWith('<p>') && textBox.endsWith('</p>')){
            textBox = this.quillText.substring(3,this.quillText.length-4)
          } else {
            textBox = this.quillText
          }

          this.newDescription = textBox;

          this.filteredArticles.filter(function(article){
            if (article.id == idArticle){
              article[property] = textBox
            }
          })
        }

        if (document.getElementById(property+"-"+idArticle).innerHTML==textBox) {
          textBox = this.escapeHtml(textBox)
        }

        document.getElementById(property+"-"+idArticle).innerHTML=textBox

      },
      escapeHtml(text) {
        var map = {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
      },
      showUserName(article){
        var username
        this.users.filter(function(user){
          if (user.id == article.id){
            username = user.name
          }
        })
        return username
      },
      cancelShow(){
        this.showedArticle = ''
        this.showedArticleUserName = ''
        this.deleting = false
      },
      showArticle(article){
        this.showedArticle = article
        var username
        this.users.filter(function(user){
          if (user.id == article.id){
            username = user.name
          }
        })
        this.showedArticleUserName = username
        document.getElementById("show-description").innerHTML = "Description: "+this.showedArticle.description
      },
      showArticleToDelete(article){
        this.showArticle(article)
        this.deleting = true
      },
      addArticle () {
        this.$emit('loading', true)
        this.creating = true
        if (config.editor == 'medium-editor') {
          console.log(document.getElementById("description").innerHTML)
          this.form.description = document.getElementById("description").innerHTML
        }
        this.form.post(API_ARTICLES_URL).then(() => {
          var createdId
          var createdName = this.form.name
          var createdDescription = this.form.description
          var createdUserId = this.form.user_id
          crudArticle.getAll().then( response => {
            createdId = response.data[response.data.length-1].id
            this.articles.push({id: createdId ,name: createdName, description: createdDescription, user_id: createdUserId, read: false})
          })
          this.form.name = ''
          this.form.description = ''
          this.form.user_id = ''
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.creating = false
          this.$emit('loading', false)
        })
      },
      deleteArticle (article) {
        this.$emit('loading', true)
        this.articleBeingDeleted = article.id
        crudArticle.destroy(article.id).then(() => {
          this.articles.splice(this.articles.indexOf(article), 1)
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.articleBeingDeleted = null
          this.$emit('loading', false)
        })
      },
      updateNewTextQuill(text,property) {
        if (property == 'name'){
          this.newTitle = text
        } else if (property == 'description'){
          this.newDescription = text
        }
      },
      getUpdateIdArticle(article,property){
        var idArticle = article.id
        if (this.editor=='quill'){
          idArticle=this.editedArticle
        } else if (this.editor =='medium-editor'){
          var newText = document.getElementById(property+'-'+article.id).innerHTML
          if (property == 'name'){
            this.newTitle = newText
          } else if (property == 'description'){
            this.newDescription = newText
          }
        }
        return idArticle
      },
      updateTitleArticle (article) {
        this.$emit('loading', true)
        crudArticle.update(article.id, {name: this.newTitle}).then((response) =>  {
          this.articles[this.articles.indexOf(article)].name = this.newTitle;
          this.newTitle = ''
          this.editedArticle = null
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      updateDescriptionArticle(article) {
        var idArticle = this.getUpdateIdArticle(article,'description')
        if (this.newDescription.startsWith('<p>') && this.newDescription.endsWith('</p>')){
          this.newDescription = this.newDescription.substring(3,this.newDescription.length-4)
        }
        this.$emit('loading', true)
        crudArticleDescription.update(idArticle, {description: this.newDescription }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      editArticleName (article) {
        this.editedArticle = article
        this.newTitle = article.title
      },
      editArticleDescription(article){
        this.editedArticle = article.id
        this.newDescription = article.description
        this.quillText = article.description
      },
      readArticle(article){
        this.$emit('loading', true)
        crudArticleRead.store(article.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      unreadArticle(article){
        this.$emit('loading', true)
        crudArticleRead.destroy(article.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        }).then(
          this.articleBeingDeleted = null
        )
      },
      fetchArticles(){
        this.$emit('loading', true)
        crudArticle.getAll().then( response => {
          this.articles = response.data
        }).catch( error => {
          console.log(error)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      fetchUsers(){
        this.$emit('loading', true)
        crudUsers.getAll().then((response) => {
          this.users = response.data
        }).catch((error) => {
          console.log(error)
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      }
    },
    mounted () {
      new MediumEditor('.editable');
      this.fetchArticles();
      this.fetchUsers();
    }
  }
</script>