<template>
  <div>
      <div class="main d-flex flex-wrap justify-content-center"> 
          <div v-for="(post ,index) in posts" :key="index" id="card">
              <p>{{post.title}}</p>
              <p> {{post.content}}</p>
              <p v-if="post.category != null">({{post.category.type}})</p><br>
              <p v-for="(tag, index) in post.tags" :key="index">#{{tag.name}}</p> <br>
              <div  v-if="post.img !=null">
                  <img class="image" :src="'storage/' + post.img" alt="">
              </div>
              <div v-else>
                  <img class="image" :src="emptyImage()" alt="">
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name:'Main',
    data(){
        return{
            posts:[]
        };
    },
    methods:{
        emptyImage(){
            return 'images/noimage.png'
        }
    },
    created(){
        axios.get('/api/posts')
    .then((response)=> {
        // handle success
        this.posts = response.data;
    })

    }
}
</script>

<style lang="scss" scoped>
.main{
    width: 100%;
    margin: 0;
    padding: 0;

}
#card{
width: 450px !important;
height: 400px !important;
border: 1px solid black;
text-align: center;
}
.image{
    width: 100px;
    height: 100px;
}
</style>

