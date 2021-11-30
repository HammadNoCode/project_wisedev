<template>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-12 col-lg">
                        <div role="group" aria-label="1" class="btn-group btn-block">
                            <button 
                                :class="{ active: tab == 'portal' }"
                                @click="tab = 'portal'"
                                class="btn btn-light" 
                            >
                                <i class="fas fa-table pr-2"></i>Portal Records
                            </button>
                            <button 
                                :class="{ active: tab == 'pulse' }"
                                @click="tab = 'pulse'"
                                class="btn btn-light" 
                            >
                                <i class="fas fa-table pr-2"></i>Pulse Records
                            </button>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div v-if="tab == 'portal'">
            <portal />
        </div>
        <div v-if="tab == 'pulse'">
            <pulse />
        </div>
    </div>
</template>
<script>
import Portal from './tables/Portal';
import Pulse from "./tables/Pulse";

export default {
    data: function() {
        return {
            tab: "portal",
        }
    },
    components: {
        Portal,
        Pulse,
    }
}
</script>