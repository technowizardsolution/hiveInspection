<template>
    <div>
        <div v-if="!firebaseMessagesLoaded" class="ui active centered inline text loader">Loading conversation...</div>
        <div id="comments-container" style="max-height: 55vh;overflow-y: scroll;padding-right:10px;padding-bottom: 40px;">
            <div v-if="historyMessages.length > 0" v-for="message in historyMessages" v-cloak>

                <div v-if="!isMe(message.userId)" class="sixteen wide column">
                    <div class="comment">
                        <a class="avatar">
                          <img src="/img/avatar/default.jpg">
                        </a>
                        <div class="content">
                          <a class="author">{{ getUserName(message.userId) }}</a>
                          <div class="metadata">
                            <span class="date">{{ humanize(message.date)  }}</span>
                          </div>
                          <div class="text">
                            <p v-html="message.text">{{ message.text }}</p>
                            <div v-if="message.image === ''">
                            </div>
                            <div v-else>
                              <img :src="message.image" height="125" controls>
                            </div>
                            <div v-if="message.video === ''">
                            </div>
                            <div v-else>
                              <video :src="message.video" height="125" controls></video>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

                <div v-else class="sixteen wide column">
                    <div  class="comment" style="text-align: right;">
                        <a class="avatar" style="float:right;">
                          <img src="/img/avatar/default.jpg">
                        </a>
                        <div class="content" style="margin-left:0;margin-right: 3.5em;">
                          <div class="metadata">
                            <span class="date">{{ humanize(message.date) }}</span>
                          </div>
                          <a class="author">Tú</a>

                          <div class="text">
                            <p v-html="message.text">{{ message.text }}</p>
                            <div v-if="message.image === ''">
                            </div>
                            <div v-else>
                              <img :src="message.image" height="125" controls>
                            </div>
                            <div v-if="message.video === ''">
                            </div>
                            <div v-else>
                              <video :src="message.video" height="125" controls></video>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>

         <div v-if="firebaseMessagesLoaded && historyMessages.length < 1">
            <p><small>There are no messages, send the first one to start the conversation.</small></p>
         </div>
         <div class="field">
           <twemoji-textarea
             :emojiData="emojiDataAll"
             :emojiGroups="emojiGroups"
             @enterKey="onEnterKey">
           </twemoji-textarea>
         </div>
        <form @submit.prevent="sendMessage()" class="ui reply form">
            <div class="field emoji-page">
                <input type="file" class="form-control" id="poster" placeholder="Upload Image">
            </div>

            <div v-if="loading">
            </div>

            <div v-if="!loading">
            </div>
        </form>
    </div>
</template>

<script>
 import {
    TwemojiTextarea
  } from '@kevinfaguiar/vue-twemoji-picker';
  import EmojiAllData from '@kevinfaguiar/vue-twemoji-picker/emoji-data/en/emoji-all-groups.json';
  import EmojiGroups from '@kevinfaguiar/vue-twemoji-picker/emoji-data/emoji-groups.json';
  console.log(database);

    export default {
        props: ['userId', 'chatId', 'receptorName'],
        components: {
          'twemoji-textarea': TwemojiTextarea
        },
        computed: {
          emojiDataAll() {
              return EmojiAllData;
          },
          emojiGroups() {
              return EmojiGroups;
          }
        },
        data() {
            return {
                message: {
                    text: '',
                    date: null
                },
                loading: false,
                historyMessages: [],
                firstLoad: false   ,
                firebaseMessagesLoaded: false
            }
        },
        mounted(){
            database.refFromURL('/chats/' + this.chatId)
                .on('value', snapshot => this.loadMessages(snapshot.val()))
        },
        methods:{
            onEnterKey(e) {
              console.log("ClickedEnter", e);
            },
            loadMessages(messages){
                this.firebaseMessagesLoaded= false;
                this.historyMessages = [];
                for(let key in messages) {
                    this.historyMessages.push({
                        userId: messages[key].fromUserId,
                        text: messages[key].text,
                        image: messages[key].imageURL,
                        video: messages[key].videoURL,
                        date: messages[key].date
                    });
                }

                this.showNotification(this.historyMessages.slice(-1).pop());
                this.firstLoad = true;
                //scroll to bottom
                document.querySelector('#comments-container').scrollTop =  document.querySelector('#comments-container').scrollHeight - document.querySelector('#comments-container').clientHeight;
                this.firebaseMessagesLoaded= true;

            },
            sendMessage(){
                this.loading = true;
                var uid = this.userId;
                // Get a key for a new Post.
                var newPostKey = database.ref('/chats/' + this.chatId).push().key;
                var imagesRef = firebase.storage().ref().child('images');
                var videoRef = firebase.storage().ref().child('video');
                var file = $('#poster').get(0).files[0];
                var msg = $('#twemoji-textarea').html();
                if(file) {
                  if(!imagesRef) imagesRef = firebase.storage().ref();
                  var mimes = {
                    "image/gif": {
                      "source": "iana",
                      "compressible": false,
                      "extensions": ["gif"]
                    },
                    "image/jpeg": {
                      "source": "iana",
                      "compressible": false,
                      "extensions": ["jpeg","jpg","jpe"]
                    },
                    "image/png": {
                      "source": "iana",
                      "compressible": false,
                      "extensions": ["png"]
                    },
                    "image/svg+xml": {
                      "source": "iana",
                      "compressible": true,
                      "extensions": ["svg","svgz"]
                    },
                    "image/webp": {
                      "source": "apache",
                      "extensions": ["webp"]
                    },
                    "video/mp4": {
                      "source": "iana",
                      "extensions": ["mp4"]
                    },
                    "video/MPV": {
                      "source": "iana",
                      "extensions": ["MPV"]
                    },
                    "video/3gpp": {
                      "source": "iana",
                      "extensions": ["3gpp"]
                    },
                  };
                  // Create the file metadata
                  var metadata = {
                    contentType: file.type
                  };
                  if(mimes[file.type]) {
                    if(file.type == 'video/mp4' || file.type == 'video/MPV' || file.type == 'video/3gpp') {
                        // Upload video file and metadata to the object
                        var task = videoRef.child(newPostKey + '.' + mimes[file.type].extensions[0]).put(file, metadata);
                        task.then((snapshot) => {
                            snapshot.ref.getDownloadURL().then((url) => {
                                database.ref('/chats/' + this.chatId).push({
                                    fromUserId: this.userId,
                                    text: msg,
                                    imageURL: '',
                                    videoURL: url,
                                    name: this.receptorName,
                                    timestamp: moment().toDate().getTime()
                                })
                                .then(() => {
                                    $('#twemoji-textarea').html('');
                                    $('#poster').val('');
                                });
                            });
                        });
                    } else {
                        // Upload image file and metadata to the object
                        var task = imagesRef.child(newPostKey + '.' + mimes[file.type].extensions[0]).put(file, metadata);
                        task.then((snapshot) => {
                            snapshot.ref.getDownloadURL().then((url) => {
                                database.ref('/chats/' + this.chatId).push({
                                    fromUserId: this.userId,
                                    text: msg,
                                    imageURL: url,
                                    videoURL: '',
                                    name: this.receptorName,
                                    timestamp: moment().toDate().getTime()
                                })
                                .then(() => {
                                    $('#twemoji-textarea').html('');
                                    $('#poster').val('');
                                });
                            });
                        });
                    }
                  } else {
                    alert('Please select proper file format');
                  }
                } else if(msg) {
                    database.ref('/chats/' + this.chatId).push({
                        fromUserId: this.userId,
                        text: msg,
                        imageURL: '',
                        videoURL: '',
                        name: this.receptorName,
                        timestamp: moment().toDate().getTime()
                    })
                    .then(() => {
                        $('#twemoji-textarea').html('');
                    });
                } else {
                    alert('Please select image or Type message');
                }
                this.loading = false;
            },
            getUserName(id){
                if(id == this.message.userId) {
                    return "Tú";
                }else {
                    return this.receptorName
                }
            },

            isMe(id) {
                if(id == this.userId) {
                    return true;
                }else {
                    return false;
                }
            },

            humanize(date) {
                return moment(date).format('DD-MM-YY h:mma');
            },

            showNotification(message){
                if(this.firstLoad && message.userId != this.message.userId && !windowFocus) {
                    pushjs.create(this.getUserName(message.userId), {
                        body: message.text,
                        timeout: 4000,
                        onClick: function () {
                            window.focus();
                            this.close();
                        }
                    });
                }

            }
        }
    }
</script>
<style scoped>
    .emoji-page {
        padding-top: 20px;
    }
</style>
