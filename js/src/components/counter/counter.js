import { createSignal, onCleanup } from 'solid-js';
import { Tick } from './counter.styled';

const useTick = (delay) => {
    const [getCount, setCount] = createSignal(0);
    const handle = setInterval(() => setCount(getCount() + 1), delay);
    onCleanup(() => clearInterval(handle));
    return getCount;
};

export default () => {
    const c = useTick(1000);
    return (<Tick>{c}</Tick>);
};

