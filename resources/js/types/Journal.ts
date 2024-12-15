export interface Journal {
    id?: number;
    entry: string;
    date: string;
    height: number;
    weight: number;
    image?: File | null;
}
