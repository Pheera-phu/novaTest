<template>
  <div>
    <Head title="Task" />

    <Heading class="mb-6">Task Management</Heading>

    <div class="max-w-6xl mx-auto">
      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-flex items-center">
          <svg class="animate-spin h-8 w-8 text-blue-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span class="text-lg text-gray-600">กำลังโหลดข้อมูล...</span>
        </div>
      </div>

      <!-- Content -->
      <div v-else>
        <!-- Task Statistics Card -->
        <div class="rounded-lg p-6 mb-6 text-black text-center" style="background-color:azure;">
          <h2 class="text-lg font-medium mb-2">งานที่ได้รับมอบหมายทั้งหมด</h2>
          <div class="text-4xl font-bold">{{ taskStats.total }}</div>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <!-- Pending Tasks -->
          <div class="bg-red-500 rounded-lg p-4 text-white text-center">
            <div class="flex items-center justify-center mb-2">
              <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="text-sm">รอดำเนินการ</span>
            </div>
            <div class="text-3xl font-bold">{{ taskStats.pending }}</div>
          </div>

          <!-- In Progress Tasks -->
          <div class="bg-yellow-500 rounded-lg p-4 text-white text-center">
            <div class="flex items-center justify-center mb-2">
              <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 00-1 1v6a1 1 0 001 1v1a2 2 0 01-2-2V5zM15 5a2 2 0 00-2-2v1a1 1 0 011 1v6a1 1 0 01-1 1v1a2 2 0 002-2V5z" clip-rule="evenodd"/>
              </svg>
              <span class="text-sm">กำลังดำเนินการ</span>
            </div>
            <div class="text-3xl font-bold">{{ taskStats.in_progress }}</div>
          </div>

          <!-- Completed Tasks -->
          <div class="bg-green-500 rounded-lg p-4 text-white text-center">
            <div class="flex items-center justify-center mb-2">
              <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
              <span class="text-sm">เสร็จสิ้น</span>
            </div>
            <div class="text-3xl font-bold">{{ taskStats.completed }}</div>
          </div>
        </div>

        <!-- Task Cards -->
        <div class="space-y-4">
          <div v-for="task in tasks" :key="task.id" class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Task Header with Status Color -->
            <div 
              :class="{
                'bg-red-500': task.status === 'รอดำเนินการ',
                'bg-yellow-500': task.status === 'กำลังดำเนินการ', 
                'bg-green-500': task.status === 'เสร็จสิ้น'
              }"
              class="text-white p-4"
            >
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="font-bold text-lg">Issue : {{ task.issue }}</h3>
                  <p class="text-sm opacity-90">Task : {{ task.task }}</p>
                </div>
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm" style="color: black;">
                  {{ task.status }}
                </span>
              </div>
            </div>

            <!-- Task Body -->
            <div class="p-4">
              <div class="mb-4">
                <h4 class="font-semibold text-gray-800 mb-2">รายละเอียด</h4>
                <p class="text-gray-600 text-sm mb-2">
                  <strong>Project:</strong> {{ task.project }}
                </p>
                <p class="text-gray-600 text-sm mb-2">
                  <strong>Type:</strong> {{ task.types }}
                </p>
                <p class="text-gray-600 text-sm mb-2">
                  <strong>Author:</strong> {{ task.author }}
                </p>
              </div>

              <!-- Action Buttons -->
              <div class="flex space-x-2 mb-4">
                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
                  อัพเดท
                </button>
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                  ดูรายละเอียด
                </button>
              </div>

              <!-- Timeline/Dates Section -->
              <div class="border-t pt-4">
                <button 
                  @click="toggleDetails(task.id)"
                  class="w-full flex justify-between items-center text-left text-gray-600 hover:text-gray-800"
                >
                  <span class="font-medium">รายละเอียดงาน</span>
                  <svg 
                    :class="{ 'rotate-180': expandedTasks.includes(task.id) }"
                    class="w-5 h-5 transform transition-transform"
                    fill="currentColor" 
                    viewBox="0 0 20 20"
                  >
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                  </svg>
                </button>
                
                <div v-show="expandedTasks.includes(task.id)" class="mt-4 space-y-3">
                  <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                      <strong>วันที่เริ่มต้น:</strong>
                      <p>{{ formatDate(task.start_date) }}</p>
                    </div>
                    <div>
                      <strong>วันที่สิ้นสุด:</strong>
                      <p>{{ formatDate(task.end_date) }}</p>
                    </div>
                  </div>
                  
                  <div v-if="task.remark" class="text-sm">
                    <strong>หมายเหตุ:</strong>
                    <p class="mt-1 text-gray-600">{{ task.remark }}</p>
                  </div>

                  <div v-if="task.tester" class="text-sm">
                    <strong>ผู้ทดสอบ:</strong>
                    <p class="mt-1 text-gray-600">{{ task.tester }}</p>
                  </div>

                  <div v-if="task.testRound" class="text-sm">
                    <strong>รอบการทดสอบ:</strong>
                    <p class="mt-1 text-gray-600">{{ task.testRound }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- No Tasks Message -->
        <div v-if="tasks.length === 0" class="text-center py-12">
          <div class="text-gray-400 text-lg">ไม่มีงานในระบบ</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tasks: [],
      taskStats: {
        total: 0,
        pending: 0,
        in_progress: 0,
        completed: 0
      },
      expandedTasks: [],
      loading: true
    }
  },
  
  async mounted() {
    await this.fetchTasks()
  },

  methods: {
    async fetchTasks() {
      try {
        this.loading = true
        const response = await Nova.request().get('/nova-vendor/task/tasks')
        
        this.taskStats = response.data.stats
        this.tasks = response.data.tasks
      } catch (error) {
        console.error('Error fetching tasks:', error)
        this.$toasted.error('เกิดข้อผิดพลาดในการโหลดข้อมูล')
      } finally {
        this.loading = false
      }
    },

    toggleDetails(taskId) {
      const index = this.expandedTasks.indexOf(taskId)
      if (index > -1) {
        this.expandedTasks.splice(index, 1)
      } else {
        this.expandedTasks.push(taskId)
      }
    },

    formatDate(dateString) {
      if (!dateString) return '-'
      
      const date = new Date(dateString)
      const day = date.getDate().toString().padStart(2, '0')
      const month = (date.getMonth() + 1).toString().padStart(2, '0')
      const year = date.getFullYear() + 543 // Convert to Thai Buddhist year
      
      return `${day}/${month}/${year}`
    },

    getStatusLabel(status) {
      const labels = {
        'รอดำเนินการ': 'Issue : พบปัญหา MOC Footloose',
        'กำลังดำเนินการ': 'Issue : พบปัญหา MOC Footloose', 
        'เสร็จสิ้น': 'Issue : พบปัญหา MOC Footloose'
      }
      
      return labels[status] || status
    }
  }
}
</script>

<style scoped>
.rotate-180 {
  transform: rotate(180deg);
}

.transition-transform {
  transition: transform 0.2s ease-in-out;
}

/* Card hover effects */
.bg-white:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
}

/* Status badge animations */
.bg-red-500, .bg-orange-500, .bg-green-500 {
  transition: all 0.3s ease;
}

/* Button hover effects */
button {
  transition: all 0.2s ease;
}

button:hover {
  transform: translateY(-1px);
}

/* Loading spinner */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .grid-cols-3 {
    grid-template-columns: 1fr;
  }
  
  .grid-cols-2 {
    grid-template-columns: 1fr;
  }
}

/* Thai font support */
body {
  font-family: 'Sarabun', 'Noto Sans Thai', sans-serif;
}
</style>
