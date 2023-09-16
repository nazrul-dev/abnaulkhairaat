
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'


Alpine.plugin(Clipboard.configure({
    onCopy: () => {
        window.$wireui.notify({
            title: "Berhasil Melakukan Copied Clipboard",
            icon: "success",
          });

    }
}))

 

 
Livewire.start()



