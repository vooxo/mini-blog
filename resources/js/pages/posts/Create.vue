<script setup lang="ts">

import { type BreadcrumbItem } from '@/types';
import {Head, Link, useForm} from '@inertiajs/vue3';
import PlaceholderPattern from "@/components/PlaceholderPattern.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import InputError from "@/components/InputError.vue";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {LoaderCircle} from "lucide-vue-next";

const form = useForm({
    title: '',
    content: '',
});

const submit = () => {
    form.post(route('posts.store'), {
        onFinish: () => {
            form.reset();
        },
    });
};

</script>

<template>
    <Head title="Create new post" />

    <AppLayout>
        <h1 class="text-[24px]">Add new post</h1>
        <div
            class="rounded-lg p-6 max-w-2xl"
        >
            <form @submit.prevent="submit">
                <div class="space-y-6">
                    <div class="grid gap-2">
                        <Label htmlFor="title">Title</Label>
                        <Input
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                            required
                            autofocus
                        />

                        <InputError :message="form.errors.title" />
                    </div>

                    <div class="grid gap-2">
                        <Label htmlFor="content">Content</Label>
                        <textarea
                            id="content"
                            type="text"
                            class="mt-1 block w-full border-1 h-24 rounded"
                            v-model="form.content"
                        />

                        <InputError :message="form.errors.content" />
                    </div>

                    <div class="flex items-center">
                        <Button class="w-full" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Create
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
