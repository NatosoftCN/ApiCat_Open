<template>
    <div class="ac-project-info">
        <div class="ac-project-info__img">
            <a href="/"> <img :src="project.icon" :alt="project.name" /></a>
        </div>

        <div class="ac-project-info__title" :title="project.name">
            {{ project.name }}
            <el-tooltip effect="dark" content="私有项目" placement="bottom" v-if="isPrivate">
                <el-icon class="ac-project-info__icon"><Lock /></el-icon>
            </el-tooltip>
        </div>
    </div>
</template>
<script setup lang="ts">
    import { Lock } from '@element-plus/icons-vue'
    import { storeToRefs } from 'pinia'
    import { useProjectStore } from '@/stores/project'
    const projectStore = useProjectStore()
    const { projectInfo: project, isPrivate } = storeToRefs(projectStore)
</script>
