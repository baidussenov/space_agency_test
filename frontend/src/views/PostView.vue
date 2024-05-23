<script setup>
import { dateToStr, getThumbnailPath } from '@/utils/helper'
import { baseURL } from '@/api'

import CreateCommentForm from '@/components/CreateCommentForm.vue'
import Comments from '@/components/Comments.vue'
</script>

<template>
    <Popup ref='popup' />
    <div class='container'>
        <h1 class='title'>{{ post.title }}</h1>
        <p class='descr' v-html="post.description"></p>
        <br>
        <div class='stats'>
            <div>
                <img src='@/assets/icons/view.svg' alt='views'>
                <p>{{ post.views }}</p>
            </div>
            <div class='like-wrapper' @click='like'>
                <p v-if='alreadyLiked' class='liked'>Вам нравится этот пост!</p>
                <p>{{ post.likes }}</p>
                <img src='@/assets/icons/like.svg' alt='like'>
            </div>
        </div>
        <img class='thumbnail' :src='getThumbnailPath(post.thumbnail)' alt='thumbnail'>
        <p class='content' v-html="post.content"></p>
        <router-link :to="'/edit/' + post.id" class="edit">
            <img src='@/assets/icons/edit.png' alt='delete'>
            <p>Редактировать этот пост</p>
        </router-link>
        <div class='delete' @click='deletepost'>
            <img src='@/assets/icons/delete.svg' alt='delete'>
            <p>Удалить этот пост</p>
        </div>
        <div class='details'>
            <p class='date'>{{ dateToStr(post.created_at) }}</p>
            <p class='author'>Автор: {{ post.user.name }}</p>
        </div>
        <hr>
        <CreateCommentForm :postId='post.id' />
        <Comments :comments='post.comments' />
    </div>
</template>

<script>
import api from '@/api'
import Popup from '@/components/Popup.vue'

export default {
    data() {
        return {
            post: {
                id: null,
                title: '',
                description: '',
                content: '',
                created_at: '',
                thumbnail: '',
                author: '',
                comments: [],
                views: 0,
                likes: 0
            },
            alreadyLiked: false
        }
    },
    created() {
        console.log('Fetching post...')
        this.fetchPost()
    },
    methods: {
        async fetchPost() {
            try {
                const response = await api.get(`/api/post/${this.$route.params.id}`)
                const { success, post, error } = response.data
                if (success)
                    this.post = post
                else
                    throw error
            } catch (err) {
                console.error('Ошибка при получении поста:', err)
            }
        },
        async like() {
            try {
                let request = `/api/post/${this.post.id}/`
                if (this.alreadyLiked)
                    request += 'unlike'
                else
                    request += 'like'
                const response = await api.put(request)
                const { success, likes, error } = response.data
                if (success)
                    this.post.likes = likes
                else
                    throw error

                this.alreadyLiked = !this.alreadyLiked
            } catch (err) {
                console.error('Ошибка при получении поста:', err)
            }
        },
        async deletepost() {
            try {
                const response = await api.delete(`/api/post/${this.post.id}`)
                const { success, error } = response.data
                if (!success)
                    throw error

                this.$router.push('/')
            } catch (err) {
                console.error('Ошибка при удалении поста:', err)
                this.$refs.popup.openPopup(false, 'Произошла ошибка')
            }
        }
    }
}
</script>

<style scoped>
.container {
    margin: 0 auto;
    padding: 0 10%;
    margin-bottom: 2.5rem;
}

.title {
    font-size: 2rem;
    text-transform: uppercase;
    font-weight: bold;
}

.descr {
    font-size: 1.3rem;
}

.like-wrapper:hover {
    cursor: pointer;
}

.liked {
    color: green;
}

.thumbnail {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    margin: 1.5rem 0;
}

.content {
    font-size: 1rem;
    margin-bottom: 30px;
}

.edit {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    align-items: center;
    color: blue;
    text-transform: uppercase;
    margin-bottom: 15px;
}

.delete {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    align-items: center;
    color: red;
    text-transform: uppercase;
    margin-bottom: 15px;
}


.edit:hover,
.delete:hover {
    cursor: pointer;
    text-decoration: underline;
}

.edit img,
.delete img {
    display: none;
    margin-right: 5px;
    height: 1.2rem;
}

.edit:hover img,
.delete:hover img {
    display: block;
}

.edit p,
.delete p {
    font-weight: bold;
}

.details {
    display: flex;
    width: 100%;
    flex-direction: row;
    justify-content: space-between;
    font-size: 1.3rem;
}
</style>