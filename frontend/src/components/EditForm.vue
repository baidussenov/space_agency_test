<script setup>
import Spinner from '@/components/Spinner.vue'
</script>

<template>
    <Spinner :show='loading' />
    <Popup ref='popup' />
    <form @submit.prevent='submitForm'>
        <div class='row'>
            <div class='form-group'>
                <label for='title'>Название*</label>
                <input type='text' id='title' v-model='post.title' required class='form-control' name='title' autofocus>
            </div>
            <div class='form-group'>
                <label for='description'>Краткое описание*</label>
                <textarea id='description' v-model='post.description' required class='form-control'
                    name='description'></textarea>
            </div>
        </div>
        <div class='row'>
            <div class='form-group'>
                <label for='thumbnail'>Главное изображение</label>
                <br>
                <input type='file' id='thumbnail' @change='handleThumbnailChange' accept='image/*' name='thumbnail'>
            </div>
            <div class='form-group'>
                <label for='author'>Автор*</label>
                <input type='text' id='author' v-model='post.user.name' required class='form-control' name='author'>
            </div>
        </div>
        <div class='form-group'>
            <label for='text'>Содержимое*</label>
            <textarea id='text' v-model='post.content' required class='form-control' name='content'></textarea>
        </div>
        <button type='submit'>Добавить</button>
    </form>
</template>

<script>
import api from '@/api'
import Popup from '@/components/Popup.vue'

export default {
    components: {
        Popup
    },
    data() {
        return {
            post: {
                title: '',
                description: '',
                thumbnail: null,
                content: '',
                author: ''
            },
            loading: false
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
                console.log(response.data)
                if (success)
                    this.post = post
                else
                    throw error
            } catch (err) {
                console.error('Ошибка при получении поста:', err)
            }
        },
        handleThumbnailChange(event) {
            this.post.thumbnail = event.target.files[0]
        },
        async submitForm() {
            this.loading = true
            let formData = new FormData()
            formData.append('title', this.post.title)
            formData.append('description', this.post.description)
            formData.append('content', this.post.content)
            if (this.post.thumbnail != null)
                formData.append('thumbnail', this.post.thumbnail)
            formData.append('author', this.post.author)

            await this.submitFormDataToServer(formData)
        },
        async submitFormDataToServer(formData) {
            try {
                const response = await api.post('/api/post', formData, {
                    headers: { 'Content-Type': 'multipart/form-data; charset=utf-8' }
                })
                const { success, error } = response.data
                if (!success)
                    throw error
                this.clearForm()
                this.$refs.popup.openPopup(true, 'Пост успешно опубликован!')
            } catch (err) {
                console.error('Ошибка при добавлении поста:', err)
                this.$refs.popup.openPopup(false, 'Произошла ошибка')
            }
            this.loading = false
        },
        clearForm() {
            this.post = {
                title: '',
                description: '',
                thumbnail: null,
                content: '',
                author: ''
            }
        }
    }
}
</script>