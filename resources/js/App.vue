<template>
  <div class="flex flex-col md:flex-row min-h-screen bg-[#0b1120] text-slate-300 font-sans selection:bg-blue-500/30">

    <header class="md:hidden flex items-center justify-between bg-[#0f172a] border-b border-slate-800/50 p-4 sticky top-0 z-40">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-xl"></div>
        <p class="font-bold text-xl tracking-tight text-white">TaskMaster</p>
      </div>
    </header>

    <aside class="w-64 bg-[#0f172a] border-r border-slate-800/50 flex flex-col p-6 hidden md:flex sticky top-0 h-screen">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-2xl"></div>
        <p class="font-bold text-2xl tracking-tight text-white">TaskMaster</p>
      </div>

      <div class="mb-8 bg-[#1e293b] rounded-2xl p-5 border border-slate-700">
        <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Live Status</p>
        <div class="space-y-4 text-sm">
          <div class="flex justify-between"><span class="text-slate-400">Pending</span><span class="font-mono font-bold">{{ counts.pending }}</span></div>
          <div class="flex justify-between"><span class="text-amber-400">In Progress</span><span class="font-mono font-bold text-amber-400">{{ counts.in_progress }}</span></div>
          <div class="flex justify-between"><span class="text-emerald-400">Done</span><span class="font-mono font-bold text-emerald-400">{{ counts.done }}</span></div>
        </div>
      </div>

      <nav class="space-y-2 flex-1">
        <button @click="view = 'board'" :class="view === 'board' ? 'bg-blue-500 text-white' : 'text-slate-400 hover:text-slate-200'" class="w-full text-left px-5 py-3 rounded-xl font-semibold flex items-center gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2 2 2 0 01-2 2v-2m4-4v-4" /></svg>
          Tasks
        </button>
        <button @click="view = 'report'" :class="view === 'report' ? 'bg-blue-500 text-white' : 'text-slate-400 hover:text-slate-200'" class="w-full text-left px-5 py-3 rounded-xl font-semibold flex items-center gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-9 9-4-4-6 6" /></svg>
          Analytics
        </button>
      </nav>
    </aside>

    <main class="flex-1 p-4 md:p-10 pb-24 md:pb-10 overflow-y-auto w-full">

      <div v-if="view === 'board'" class="max-w-4xl mx-auto space-y-6 md:space-y-8">

        <div class="md:hidden flex justify-between bg-[#1e293b] p-4 rounded-xl border border-slate-700 shadow-sm">
          <div class="flex flex-col items-center"><span class="text-slate-400 text-[10px] font-black uppercase tracking-wider mb-1">Pending</span><span class="font-mono font-bold text-lg">{{ counts.pending }}</span></div>
          <div class="flex flex-col items-center"><span class="text-amber-400 text-[10px] font-black uppercase tracking-wider mb-1">Working</span><span class="font-mono font-bold text-amber-400 text-lg">{{ counts.in_progress }}</span></div>
          <div class="flex flex-col items-center"><span class="text-emerald-400 text-[10px] font-black uppercase tracking-wider mb-1">Done</span><span class="font-mono font-bold text-emerald-400 text-lg">{{ counts.done }}</span></div>
        </div>

        <div v-if="successMessage" class="bg-emerald-400/10 border border-emerald-400 text-emerald-400 px-6 py-4 rounded-2xl flex items-center gap-3 text-sm font-medium">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7" />
          </svg>
          Task saved successfully!
        </div>

        <header class="flex justify-between items-end border-b border-slate-800/50 pb-4 md:pb-6">
          <h1 class="text-2xl md:text-3xl font-light tracking-tight text-white hidden md:block">Tasks</h1>
          <button @click="toggleCreateForm" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg flex items-center gap-2 w-full md:w-auto justify-center">
            {{ showForm ? 'Cancel' : '+ Create New Task' }}
          </button>
        </header>

        <section v-if="showForm" class="bg-[#1e293b] p-5 md:p-6 rounded-2xl border border-slate-700 shadow-xl">
          <form @submit.prevent="createTask" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6 space-y-1">
              <label class="text-[10px] uppercase font-bold text-slate-500 pl-1">Title</label>
              <input v-model="form.title" placeholder="e.g. Update API endpoints" class="w-full bg-[#0b1120] border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500" required>
            </div>
            <div class="md:col-span-3 space-y-1">
              <label class="text-[10px] uppercase font-bold text-slate-500 pl-1">Due Date</label>
              <input v-model="form.due_date" type="date" class="w-full bg-[#0b1120] border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500" required>
            </div>
            <div class="md:col-span-3 space-y-1">
              <label class="text-[10px] uppercase font-bold text-slate-500 pl-1">Priority</label>
              <select v-model="form.priority" class="w-full bg-[#0b1120] border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500">
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
              </select>
            </div>

            <div class="md:col-span-12 flex flex-col md:flex-row items-center gap-3 mt-4">
              <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold">Publish Task</button>
              <span v-if="error" class="text-red-400 text-sm text-center">{{ error }}</span>
            </div>
          </form>
        </section>

        <div class="flex gap-2 flex-wrap">
          <button v-for="f in filters" :key="f.value" @click="activeFilter = f.value"
            :class="activeFilter === f.value ? 'bg-blue-500/20 text-blue-400 border-blue-500/50' : 'bg-[#1e293b] border-slate-800 text-slate-400 hover:text-slate-200'"
            class="border px-4 py-1.5 rounded-xl text-[11px] md:text-xs font-bold uppercase tracking-wider transition-all flex-1 md:flex-none text-center">
            {{ f.label }}
          </button>
        </div>

        <div class="space-y-3">
          <article v-for="task in filteredTasks" :key="task.id"
            class="bg-[#1e293b] p-4 rounded-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between group hover:border-slate-600 transition-all gap-4">
            <div class="flex items-start md:items-center gap-3 md:gap-4">
              <div :class="{
                'bg-red-500': task.priority === 'high',
                'bg-amber-400': task.priority === 'medium',
                'bg-emerald-500': task.priority === 'low'
              }" class="w-2 h-2 rounded-full mt-2 md:mt-0 flex-shrink-0"></div>
              <div>
                <h3 :class="{ 'line-through text-slate-500': task.status === 'done' }" class="font-semibold text-sm md:text-base leading-tight">{{ task.title }}</h3>
                <div class="flex flex-wrap items-center gap-3 text-[11px] md:text-xs mt-1.5">
                  <span class="font-mono text-slate-400">{{ task.due_date }}</span>
                  <span class="font-black uppercase" :class="{
                    'text-red-400': task.priority === 'high',
                    'text-amber-400': task.priority === 'medium',
                    'text-emerald-400': task.priority === 'low'
                  }">{{ task.priority }}</span>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto mt-2 md:mt-0">
              <button v-if="task.status === 'pending'" @click="changeStatus(task.id, 'in_progress')" class="flex-1 md:flex-none px-4 py-2 md:py-1.5 rounded-lg text-xs font-bold bg-amber-400/10 text-amber-400 border border-amber-400/20 hover:bg-amber-400 hover:text-[#0b1120]">Start Working</button>
              <button v-if="task.status === 'in_progress'" @click="changeStatus(task.id, 'done')" class="flex-1 md:flex-none px-4 py-2 md:py-1.5 rounded-lg text-xs font-bold bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 hover:bg-emerald-400 hover:text-[#0b1120]">Mark as Done</button>
              <button v-if="task.status === 'done'" @click="deleteTask(task.id)" class="flex-1 md:flex-none px-4 py-2 md:py-1.5 rounded-lg text-xs font-bold text-red-400 hover:bg-red-500 hover:text-white border border-red-500/20 md:border-transparent">Delete</button>
            </div>
          </article>
        </div>

        <div v-if="filteredTasks.length === 0" class="text-center py-20 text-slate-500 font-mono">No tasks found</div>
      </div>

      <div v-if="view === 'report'" class="max-w-4xl mx-auto space-y-6 md:space-y-8">
        <header class="flex flex-col md:flex-row md:justify-between md:items-end border-b border-slate-800/50 pb-4 md:pb-6 gap-4">
          <h1 class="text-2xl md:text-3xl font-light tracking-tight text-white">Analytics</h1>
          <input v-model="reportDate" type="date" @change="fetchReport" class="bg-[#1e293b] border border-slate-700 px-4 py-2.5 md:py-2 rounded-xl text-sm w-full md:w-auto">
        </header>

        <div v-if="report" class="grid grid-cols-3 gap-3 md:gap-6 bg-[#1e293b] p-4 md:p-6 rounded-2xl border border-slate-700">
          <div class="text-center"><div class="text-slate-400 text-[10px] md:text-xs font-bold mb-1">PENDING</div><div class="text-2xl md:text-3xl font-light">{{ totalPending }}</div></div>
          <div class="text-center"><div class="text-amber-400 text-[10px] md:text-xs font-bold mb-1">WORKING</div><div class="text-2xl md:text-3xl font-light text-amber-400">{{ totalInProgress }}</div></div>
          <div class="text-center"><div class="text-emerald-400 text-[10px] md:text-xs font-bold mb-1">DONE</div><div class="text-2xl md:text-3xl font-light text-emerald-400">{{ totalDone }}</div></div>
        </div>

        <div v-if="report" class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
          <div v-for="(stats, prio) in report.summary" :key="prio" class="bg-[#1e293b] p-5 md:p-6 rounded-2xl border border-slate-700">
            <p class="uppercase text-xs font-black mb-5 md:mb-6 flex items-center gap-2">
              <span :class="{'bg-red-500': prio==='high', 'bg-amber-400': prio==='medium', 'bg-emerald-500': prio==='low'}" class="w-2 h-2 rounded-full"></span>
              {{ prio }} Priority
            </p>
            <div class="space-y-3 md:space-y-4 text-sm">
              <div v-for="(count, status) in stats" :key="status" class="flex justify-between items-center">
                <span class="text-slate-400 text-xs md:text-sm">{{ status.replace('_',' ') }}</span>
                <span class="font-mono bg-[#0b1120] px-2 py-1 rounded text-xs">{{ count }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-[#0f172a] border-t border-slate-800 z-50 flex justify-around items-center pb-safe">
      <button @click="view = 'board'" :class="view === 'board' ? 'text-blue-500' : 'text-slate-500 hover:text-slate-300'" class="flex flex-col items-center gap-1 transition-colors p-3 w-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2 2 2 0 01-2 2v-2m4-4v-4" /></svg>
        <span class="text-[10px] font-bold uppercase tracking-wider">Tasks</span>
      </button>
      <button @click="view = 'report'" :class="view === 'report' ? 'text-blue-500' : 'text-slate-500 hover:text-slate-300'" class="flex flex-col items-center gap-1 transition-colors p-3 w-1/2 border-l border-slate-800/50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-9 9-4-4-6 6" /></svg>
        <span class="text-[10px] font-bold uppercase tracking-wider">Analytics</span>
      </button>
    </nav>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const tasks = ref([])
const report = ref(null)
const view = ref('board')
const showForm = ref(false)
const activeFilter = ref('all')
const error = ref('')
const successMessage = ref('')

const form = ref({ title: '', due_date: '', priority: 'medium' })
const reportDate = ref(new Date().toISOString().split('T')[0])

const filters = [
  { value: 'all', label: 'All' },
  { value: 'pending', label: 'Pending' },
  { value: 'in_progress', label: 'In Progress' },
  { value: 'done', label: 'Done' }
]

const counts = computed(() => ({
  pending: tasks.value.filter(t => t.status === 'pending').length,
  in_progress: tasks.value.filter(t => t.status === 'in_progress').length,
  done: tasks.value.filter(t => t.status === 'done').length
}))

const filteredTasks = computed(() => activeFilter.value === 'all' ? tasks.value : tasks.value.filter(t => t.status === activeFilter.value))

const totalPending = computed(() => report.value ? Object.values(report.value.summary).reduce((a, b) => a + b.pending, 0) : 0)
const totalInProgress = computed(() => report.value ? Object.values(report.value.summary).reduce((a, b) => a + b.in_progress, 0) : 0)
const totalDone = computed(() => report.value ? Object.values(report.value.summary).reduce((a, b) => a + b.done, 0) : 0)

const getTasks = async () => { const res = await axios.get('/api/tasks'); tasks.value = res.data.data || [] }

const createTask = async () => {
  error.value = ''
  successMessage.value = ''
  try {
    await axios.post('/api/tasks', form.value)
    successMessage.value = 'Task saved successfully!'
    form.value = { title: '', due_date: '', priority: 'medium' }
    showForm.value = false
    setTimeout(() => successMessage.value = '', 4000)
    await getTasks()
  } catch (e) {
    error.value = e.response?.data?.message || 'Validation failed'
  }
}

const toggleCreateForm = () => {
  showForm.value = !showForm.value
  error.value = ''
  successMessage.value = ''
}

const changeStatus = async (id, status) => {
  await axios.patch(`/api/tasks/${id}/status`, { status })
  await getTasks()
}

const deleteTask = async (id) => {
  if (!confirm('Delete this completed task?')) return
  await axios.delete(`/api/tasks/${id}`)
  await getTasks()
}

const fetchReport = async () => {
  const res = await axios.get(`/api/tasks/report?date=${reportDate.value}`)
  report.value = res.data
}

onMounted(() => {
  getTasks()
  fetchReport()
})
</script>

<style>
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: #0b1120; }
::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 4px; }
</style>