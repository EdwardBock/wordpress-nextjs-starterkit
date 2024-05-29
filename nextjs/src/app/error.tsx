'use client';

import {useEffect} from 'react';

type Props = {
    error: Error & { digest?: string }
    reset: () => void
}

export default function GlobalError(
    {
        error,
        reset,
    }: Props
) {
    useEffect(() => {
        console.error(error)
    }, [error])

    return (
        <div>
            <h2>Something went wrong!</h2>
            <button onClick={reset}>Try again</button>
        </div>
    )
}