import { createState, createContext } from "solid-js";

export const AppContext = createContext([{ count: 0 }, {}]);

export function AppProvider(props) {

    const [state, setState] = createState({ 
        indexes: { list: props.appState.indexes || []}
    });

    const store = [
        state, {
            indexes: {
                reindex: (name) => {
                    setState('indexes', (indexes) => {
                        const index = [...indexes.list].find(index => index.name === name);
                        if (index) {
                            index.status = 'reindexing';
                        }
                        return {list: [...indexes.list]};
                    });
                },
                reindexDone: (name) => {
                    setState('indexes', indexes => {
                        const index = [...indexes.list].find(index => index.name === name);
                        if (index) {
                            index.status = 'idle';
                        }
                        return {list: [...indexes.list]};
                    });
                },
            }
        }
    ];

    return (
        <AppContext.Provider value={store}>
            {props.children}
        </AppContext.Provider>
    );
};
