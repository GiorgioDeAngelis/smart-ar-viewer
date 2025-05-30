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
**IMPORTANTE**: I file USDZ NON sono supportati per la visualizzazione web da model-viewer. Sono utilizzati SOLO per l'AR su dispositivi iOS.

Quando selezioni un file USDZ (es. `model.usdz`), il plugin:
1. Usa il file USDZ per l'AR su iOS (attributo ios-src)
2. Cerca automaticamente `model.glb` per la visualizzazione web
3. Se non trova il GLB, cerca `model.gltf`
4. **Se non trova nessun fallback GLB/GLTF, il modello NON sarà visibile nella pagina web** (solo in AR)

**Soluzione**: Per ogni file USDZ, assicurati di avere anche un file GLB o GLTF con lo stesso nome base:
- `model.usdz` + `model.glb` ✅
- `model.usdz` + `model.gltf` ✅
- Solo `model.usdz` ❌ (non visibile nella pagina web)

## File di esempio:
- `example-model.glb` - Modello di esempio in formato GLB
- `sample-model.usdz` - Modello di esempio in formato USDZ