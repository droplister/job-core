<?php

namespace Droplister\JobCore\App\Traits;

trait ChunksParagraphs
{
    /**
     * Chunk Paragraphs
     * One Per Sentence
     */
    public static function chunkParagraphs($blob)
    {
        $skip_array = [

            '.',

            'i.e', 'e.g', '\(i.e', '\(e.g',

            'U.S', 'H.M', 'U.S.C', 'P.L', 'LL.B', 

            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 
            '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',

            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 

            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 

            'A ', 'B ', 'C ', 'D ', 'E ', 

            'Jr', 'Mr', 'Mrs', 'Ms', 'Dr', 'Prof', 'Sr', 'J.D', 'Ph.D',
            'jr', 'mr', 'mrs', 'ms', 'dr', 'prof', 'sr', 'j.d', 'ph.d',

            'col','gen', 'lt', 'cmdr',

            'Ft', 
            'ft', 

            'Dept', 'Univ', 'Div',
            'dept', 'univ', 'div',

            'inc', 'ltd',
            'Inc', 'Ltd',

            'arc', 'al', 'ave', 'cl', 'ct', 'cres', 'dr', 'st',
            'Arc', 'Al', 'Ave', 'Cl', 'Ct', 'Cres', 'Dr', 'St',

            'la', 'pl', 'plz', 'rd', 'tce',
            'La', 'Pl', 'Plz', 'Rd', 'Tce',

            'Ala' , 'Ariz', 'Ark', 'Cal', 'Calif', 'Col', 'Colo', 'Conn',
            'Del', 'Fed' , 'Fla', 'Ga', 'Ida', 'Id', 'Ill', 'Ind', 'Ia',
            'Kan', 'Kans', 'Ken', 'Ky' , 'La', 'Me', 'Md', 'Is', 'Mass', 
            'Mich', 'Minn', 'Miss', 'Mo', 'Mont', 'Neb', 'Nebr' , 'Nev',
            'Mex', 'Okla', 'Ok', 'Ore', 'Oreg', 'Penna', 'Penn', 'Pa', 'Dak',
            'Tenn', 'Tex', 'Ut', 'Vt', 'Va', 'Wash', 'Wis', 'Wisc', 'Wy',
            'Wyo', 'USAFA', 'Alta' , 'Man', 'Ont', 'Que', 'Sask', 'Yuk',

            'jan', 'feb', 'mar', 'apr', 'may', 'jun',
            'jul', 'aug', 'sep', 'oct', 'nov', 'dec', 'sept',

            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Sept',

            'vs', 'etc', 'no',
            'Vs', 'Etc', 'No',
        ];

        $skip = '';
        foreach($skip_array as $abbr)
        {
            $skip = $skip . (empty($skip) ? '' : '|') . '\s{1}' . $abbr . '[.!?]';
        }

        return preg_split("/(?<!$skip)(?<=[.?!])\s+(?=[^a-z])/", $blob, -1, PREG_SPLIT_NO_EMPTY);
    }
}