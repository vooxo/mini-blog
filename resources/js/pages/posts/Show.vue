<script setup lang="ts">

import {Head, Link, router, useForm} from '@inertiajs/vue3';
import InputError from "@/components/InputError.vue";
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

function deleteComment(commentId) {
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

    <div class="flex flex-col items-left bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-left gap-4">
                <Link
                    :href="route('posts.index')"
                    class="inline-block rounded-sm border px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Blog
                </Link>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
    </div>

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
                        v-if="$page.props.auth?.user == post.user?.id"
                        @click="editPost(props.post.id)"
                        class="mx-2"
                    >
                        Edit post
                    </Button>
                    <Button
                        v-if="$page.props.auth.user?.id == post.user?.id || $page.props.auth.user?.is_admin"
                        @click="deletePost(props.post.id)"
                        class="mx-2"
                    >
                        Delete
                    </Button>
                </div>
            </div>

            <!-- New comment form -->
            <div class="border-b">
                <form @submit.prevent="postComment">
                    <div class="p-4">
                        <div class="grid gap-2">
                            <h3>Add your comment</h3>
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

                        <span v-if="comment.user">{{ comment.user.name }}</span>
                        <span v-else class="italic">Anonymous</span>

                        <div>{{ new Date(comment.created_at).toLocaleString() }}</div>
                        <div>{{ comment.comment }}</div>

                        <!-- Delete comment -->
                        <div class="pt-4">
                            <Button
                                v-if="$page.props.auth.user?.id == comment.user?.id || $page.props.auth.user?.is_admin"
                                @click="deleteComment(comment.id)"
                            >
                                Delete comment
                            </Button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
</template>
