<script setup>
import Spinner from '@/components/Spinner.vue'
</script>

<template>
    <Spinner :show='loading' />
    <Popup ref='popup' />
    <form @submit.prevent='submitForm'>
        <div class='row'>
            <div class='form-group'>
                <label for='username'>Имя пользователя*</label>
                <input type='text' id='username' v-model='comment.username' required class='form-control' name='username'>
            </div>
            <div class='form-group'>
                <label for='content'>Комментарии*</label>
                <textarea id='content' v-model='comment.content' required class='form-control' name='content'></textarea>
            </div>
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
    props: {
        postId: Number
    },
    data() {
        return {
            comment: {
                username: '',
                content: ''
            },
            loading: false
        }
    },
    methods: {
        handleThumbnailChange(event) {
            this.post.thumbnail = event.target.files[0]
        },
        async submitForm() {
            this.loading = true

            const data = {
                ...this.comment,
                post_id: this.$props.postId
            }
            this.submitFormDataToServer(data)
        },
        async submitFormDataToServer(data) {
            console.log(data)
            try {
                const response = await api.post('/api/comment', data, {
                    headers: { 'Content-Type': 'application/json; charset=utf-8' }
                })
                const { success, error } = response.data
                if (!success)
                    throw error

                window.location.reload()
            } catch (err) {
                console.error('Ошибка при добавлении комментария:', err)
                this.$refs.popup.openPopup(false, 'Произошла ошибка')
            }
            this.loading = false
        }
    }
}
</script>