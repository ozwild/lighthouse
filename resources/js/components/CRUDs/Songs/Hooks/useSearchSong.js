import React, {useState} from 'react';
import {useAsync} from "react-async-hook";
import useConstant from 'use-constant';
import AwesomeDebouncePromise from 'awesome-debounce-promise';
import SongModel from "../../../../Models/SongModel";

const _searchSong = async (
    query
) => {
    if (!query) {
        return;
    }
    /*const result = await fetch(
        `/api/songs/search?query=${encodeURIComponent(query)}`,
        {
            signal: abortSignal,
        }
    );*/

    const result = await SongModel.searchSong(query);

    if (result.status !== 200) {
        throw new Error('bad status = ' + result.status);
    }
    const json = await result.json();
    return json.results;
};

const useSearchSong = () => {
    // Handle the input text state
    const [inputText, setInputText] = useState('');

    // Debounce the original search async function
    const debouncedSearchSong = useConstant(() =>
        AwesomeDebouncePromise(SongModel.searchSong, 500)
    );

    const search = useAsync(debouncedSearchSong, [inputText]);

    // Return everything needed for the hook consumer
    return {
        inputText,
        setInputText,
        search,
    };
};

export default useSearchSong;