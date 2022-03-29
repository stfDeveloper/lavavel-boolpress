<template>
    <div class="card">
        <h1>{{ post.title }}</h1>
        <div v-html="post.content"></div>
        <p v-if="post.category != null">({{ post.category.type }})</p>
        <br />
        <p v-for="(tag, index) in post.tags" :key="index">#{{ tag.name }}</p>
        <br />
        <div v-if="post.img != null">
            <img class="image" :src="'storage/' + post.img" alt="" />
        </div>
        <div v-else>
            <img class="image" :src="emptyImage()" alt="" />
        </div>
    </div>
</template>

<script>
export default {
    name: "Post",
    data() {
        return {
            post: {},
        }
    },
    created(){
        axios.get(`/api/posts/${this.$route.params.slug}`).then((response) => {
            // handle success
            this.post = response.data;
        });
    },
    methods:{
        emptyImage(){
            return 'images/noimage.png'
        }
    }
};
</script>

<style lang="scss" scoped>
.card{
  background-color: red;
  color: white;
}
</style>
