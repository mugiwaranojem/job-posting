import { ref } from 'vue'

const events = ref(new Map())

export const eventBus = {
  on(event: string, callback: Function) {
    events.value.set(event, callback)
  },
  emit(event: string, ...args: any[]) {
    if (events.value.has(event)) {
      events.value.get(event)(...args)
    }
  },
}
