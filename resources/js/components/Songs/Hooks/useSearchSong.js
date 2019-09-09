import React, {useState} from 'react';
import {useAsync} from "react-async-hook";
import useConstant from 'use-constant';
import AwesomeDebouncePromise from 'awesome-debounce-promise';
import SongService from "../../../Services/SongService";

const useSearchSong = () => {

    const [inputText, setInputText] = useState('');

    const debouncedSearchSong = useConstant(() =>
        AwesomeDebouncePromise(SongService.searchSong, 500)
    );

    const search = useAsync(debouncedSearchSong, [inputText]);

    return {
        inputText,
        setInputText,
        search,
    };
};

export default useSearchSong;