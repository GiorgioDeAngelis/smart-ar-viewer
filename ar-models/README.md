# AR Models Folder

Questa cartella contiene i modelli 3D locali che possono essere selezionati direttamente dal widget Elementor.

## Formati supportati:
- GLB (formato binario glTF)
- GLTF (formato JSON glTF)
- USDZ (formato Apple per AR)

## Come utilizzare:
1. Carica i tuoi modelli 3D in questa cartella
2. Nel widget Elementor SMART AR VIEWER, seleziona "Local Models" come Model Source
3. Scegli il modello desiderato dal menu a tendina

## Note:
- I modelli devono avere estensioni .glb, .gltf o .usdz
- Assicurati che i file siano ottimizzati per il web
- Per modelli USDZ, verrà automaticamente aggiunto l'attributo ios-src per la compatibilità iOS
- **IMPORTANTE**: I file USDZ non sono supportati per la visualizzazione web. Se selezioni un modello USDZ, il plugin cercherà automaticamente un file GLB o GLTF con lo stesso nome per la visualizzazione web

## Strategia di Fallback USDZ:
Quando selezioni un file USDZ (es. `model.usdz`), il plugin:
1. Usa il file USDZ per l'AR su iOS (attributo ios-src)
2. Cerca automaticamente `model.glb` per la visualizzazione web
3. Se non trova il GLB, cerca `model.gltf`
4. Se non trova nessun fallback, il modello non sarà visibile nella pagina web

## File di esempio:
- `example-model.glb` - Modello di esempio in formato GLB
- `sample-model.usdz` - Modello di esempio in formato USDZ