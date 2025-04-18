<script setup lang="ts">

import {Head, Link, router, useForm} from '@inertiajs/vue3';
import AppLayout from "@/layouts/AppLayout.vue";
import InputError from "@/components/InputError.vue";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {LoaderCircle} from "lucide-vue-next";

const props = defineProps({
    post: Object
});

const newCommentForm = useForm({
    comment: '',
});

const postComment = () => {
    newCommentForm.post(route('posts.comments.store', {
        post: props.post.id
    }), {
        onSuccess: () => newCommentForm.reset(),
    });
};

function deletePost(postId) {
    if (confirm('Delete post?')) {
        router.delete(`/posts/${postId}`, {
            onFinish: () => {
                router.reload();
            },
        });
    }
}

function editPost(postId) {
    router.get(`/posts/${postId}/edit`);
}

function deleteComment(postId, commentId) {
    if (confirm('Delete comment?')) {
        router.delete(`/comments/${commentId}`, {
            onFinish: () => {
                router.reload();
            },
        });
    }
}

</script>

<template>
    <Head title="Post" />

    <AppLayout>
        <div class="wrapper max-w-2xl">

            <!-- Post content -->
            <div class="p-4 border-b">
                <div class="meta pb-2">
                    <div>{{ post.user.name }}</div>
                    <div>{{ new Date(post.created_at).toLocaleString() }}</div>
                </div>

                <h1 class="text-2xl">{{ post.title }}</h1>
                <div>{{ post.content }}</div>

                <!-- Post actions -->
                <div class="py-4">
                    <Button
                        v-if="$page.props.auth.user && $page.props.auth.user.id == post.user.id"
                        @click="editPost(props.post.id)"
                        class="mx-2"
                    >
                        Edit post
                    </Button>
                    <Button
                        v-if="$page.props.auth.user && $page.props.auth.user.id == post.user.id"
                        @click="deletePost(props.post.id)"
                        class="mx-2"
                    >
                        Delete
                    </Button>
                </div>
            </div>

            <!-- New comment form -->
            <div v-if="$page.props.auth.user">
                <form @submit.prevent="postComment">
                    <div class="p-4">
                        <div class="grid gap-2">
                            <h3 htmlFor="comment">Add your comment</h3>
                            <textarea
                                id="comment"
                                type="text"
                                class="mt-1 block w-full border-1 h-24"
                                v-model="newCommentForm.comment"
                                required
                            />
                            <InputError :message="newCommentForm.errors.comment" />
                        </div>

                        <div class="py-4">
                            <Button class="" :disabled="newCommentForm.processing">
                                <LoaderCircle v-if="newCommentForm.processing" class="h-4 w-4 animate-spin" />
                                Add comment
                            </Button>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Comments -->
            <div v-if="post.comments && post.comments.length" id="comments" class="p-4">
                <h3 class="text-2xl">Comments:</h3>
                <ul>
                    <li v-for="comment in post.comments" :key="comment.id" class="p-4 border-b">
                        <div>{{ comment.user.name }}</div>
                        <div>{{ new Date(comment.created_at).toLocaleString() }}</div>
                        <div>{{ comment.comment }}</div>

                        <!-- Delete comment -->
                        <div class="pt-4">
                            <Button
                                v-if="$page.props.auth.user && $page.props.auth.user.id == comment.user.id"
                                @click="deleteComment(props.post.id, comment.id)"
                            >
                                Delete comment
                            </Button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
