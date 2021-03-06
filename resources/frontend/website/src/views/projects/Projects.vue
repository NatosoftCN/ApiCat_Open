<template>
    <el-card shadow="never" v-loading="isLoading">
        <template #header>
            <div class="truncate">{{ activeGroup.name }}</div>
        </template>

        <div class="ac-project">
            <div class="ac-project-item" v-for="project in projects" :key="project.id">
                <div class="ac-project-thumb">
                    <a :title="project.publicHref" :href="project.publicHref">
                        <img :src="project.icon" />
                    </a>
                    <span class="ac-project-action" :ref="setProjectDropmenuClickOutsideIgnoreEle" @click="onProjectPopperIconClick($event, project)">
                        <el-icon><caret-bottom /></el-icon>
                    </span>
                </div>
                <p :title="project.name" class="ac-project-title truncate">
                    {{ project.name }}
                </p>
            </div>

            <div class="ac-project-item ac-project-new" @click="onCreateProjectBtnClick">
                <div class="ac-project-thumb">
                    <el-icon :size="26"><plus /></el-icon>
                </div>
                <p>新建项目</p>
            </div>
        </div>
    </el-card>

    <ProjectCreateModal ref="newProjectModal" @on-ok="onCreateProjectSuccess" />
    <ProjectDropmenu
        ref="projectDropmenu"
        @change-group="loadProjectList"
        @delete-project="loadProjectList"
        @quit-project="loadProjectList"
        :ignore-ele="projectDropmenuClickOutsideIgnoreEle"
    />
</template>

<script setup lang="ts">
    import ProjectCreateModal from './components/ProjectCreateModal.vue'
    import ProjectDropmenu from './components/ProjectDropmenu.vue'
    import { Plus, CaretBottom } from '@element-plus/icons-vue'
    import { onMounted, ref, watch, onBeforeUpdate } from 'vue'
    import { getProjectList } from '@/api/project'
    import { useProjectsStore } from '@/stores/projects'
    import { storeToRefs } from 'pinia'
    import { useApi } from '@/hooks/useApi'
    import { toDocumentDetailPath } from '@/router/document.router'

    const [isLoading, getProjectListWithState] = useApi(getProjectList, { isShowMessage: false })

    const projectStore = useProjectsStore()
    const { activeGroup } = storeToRefs(projectStore)

    const projects: any = ref([])
    const newProjectModal = ref()
    const projectDropmenu = ref()

    const projectDropmenuClickOutsideIgnoreEle: any = ref([])

    const setProjectDropmenuClickOutsideIgnoreEle = (el: unknown) => {
        projectDropmenuClickOutsideIgnoreEle.value.push(el)
    }

    const onProjectPopperIconClick = (e: any, project: any) => {
        projectDropmenu.value.show(e.currentTarget, project)
    }

    const onCreateProjectBtnClick = () => {
        newProjectModal.value.show()
    }

    const onCreateProjectSuccess = async () => {
        await loadProjectList()
    }

    const loadProjectList = async () => {
        const { data } = await getProjectListWithState(activeGroup.value.id)
        if (data) {
            projects.value = (data.projects || []).map((project: any) => {
                // 默认编辑
                project.publicHref = toDocumentDetailPath({ project_id: project.id })
                return project
            })
        }
    }

    watch(
        () => activeGroup.value,
        async () => await loadProjectList()
    )

    onBeforeUpdate(() => {
        projectDropmenuClickOutsideIgnoreEle.value = []
    })

    onMounted(async () => {
        await loadProjectList()
    })
</script>
<style lang="scss" scoped>
    @use '@/assets/stylesheet/mixins/mixins' as *;

    @include b(project) {
        display: flex;
        flex-wrap: wrap;

        &-item {
            width: 128px;
            height: 128px;
            display: flex;

            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        &-new &-thumb {
            border: 1px dashed theme('borderColor.slate.300');
            color: theme('borderColor.slate.600');
            display: flex;
            align-items: center;
            justify-content: center;
        }

        &-thumb {
            cursor: pointer;
            position: relative;
            width: 64px;
            height: 64px;
            margin-bottom: 8px;
            border-radius: 4px;
            overflow: hidden;

            img {
                width: 100%;
                height: 100%;
            }
        }

        &-title {
            text-align: center;
            width: 100%;
        }

        &-action {
            position: absolute;
            width: 14px;
            height: 14px;
            line-height: 14px;
            border-radius: 2px;
            background-color: rgba(0, 0, 0, 0.47);
            cursor: pointer;
            bottom: 2px;
            right: 2px;
            opacity: 0;
            color: #fff;
        }

        &-thumb:hover &-action {
            opacity: 1;
        }
    }
</style>
