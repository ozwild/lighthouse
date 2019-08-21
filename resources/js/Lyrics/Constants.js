export const timestampRX = /(?:\[)([\d.]+)(?:])/;

export const groupRX = /[\r\n]\s{2,}/g;

export const groupSeparatorReplacement = '[break here]';

export const TIMESTAMPS_IDENTIFIERS = {
    "START": Symbol('START'),
    "END": Symbol('END'),
};