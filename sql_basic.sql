-- 問1
-- 国名を全て抽出してください。
SELECT
    name
FROM
    `countries`


-- 問2
-- ヨーロッパに属する国をすべて抽出してください。
SELECT
    name
FROM
    `countries`
WHERE
	continent = 'Europe'

-- 問3
-- ヨーロッパ以外に属する国をすべて抽出してください。
SELECT
    name
FROM
    `countries`
WHERE
	continent != 'Europe'

-- 問4
-- 人口が10万人以上の国をすべて抽出してください。
SELECT
    name
FROM
    `countries`
WHERE
	population > 100000


-- 問5
-- 平均寿命が56歳から76歳の国をすべて抽出してください。
SELECT NAME
    ,
    life_expectancy
FROM
    `countries`
WHERE
    life_expectancy BETWEEN 56 AND 76


-- 問6
-- 国コードがNLB,ALB,DZAのもの市区町村をすべて抽出してください。
SELECT NAME
    ,
    country_code,
    district
FROM
    `cities`
WHERE
    country_code = 'DZA' OR country_code = 'ALB' OR country_code = 'NLB';


-- 問7
-- 独立独立記念日がない国をすべて抽出してください。
SELECT NAME
    ,
    indep_year
FROM
    `countries`
WHERE
   indep_year IS NULL;


-- 問8
-- 独立独立記念日がある国をすべて抽出してください。
SELECT NAME
    ,
    indep_year
FROM
    `countries`
WHERE
   indep_year IS NOT NULL;


-- 問9
-- 名前の末尾が「ia」で終わる国を抽出してください。
SELECT NAME
FROM
    `countries`
WHERE NAME LIKE
    '%ia';


-- 問10
-- 名前の中に「st」が含まれる国を抽出してください。
SELECT NAME
FROM
    `countries`
WHERE NAME LIKE
    '%st%';


-- 問11
-- 名前が「an」で始まる国を抽出してください。
SELECT NAME
FROM
    `countries`
WHERE NAME LIKE
    'an%';

-- 問12
-- 全国の中から独立記念日が1990年より前または人口が10万人より多い国を全て抽出してください。
SELECT NAME
    ,
    indep_year,
    population
FROM
    `countries`
WHERE
    indep_year < 1990 OR population > 100000;


-- 問13
-- コードがDZAもしくはALBかつ独立記念日が1990年より前の国を全て抽出してください。
SELECT NAME
    ,
    CODE,
    indep_year
FROM
    `countries`
WHERE CODE
    = 'DZA' OR CODE = 'ALB' AND indep_year < 1990;


-- 問14
-- 全ての地方をグループ化せずに表示してください。
SELECT DISTINCT
    (region)
FROM
    `countries`;


-- 問15
-- 国名と人口を以下のように表示させてください。シングルクォートに注意してください。
-- 「Arubaの人口は103000人です」
SELECT NAME
    ,
    'の人口は',
    population,
    '人です'
FROM
    `countries`;

-- 問16
-- 平均寿命が短い順に国名を表示させてください。ただしNULLは表示させないでください。
SELECT NAME
    ,
    life_expectancy
FROM
    `countries`
WHERE
    life_expectancy IS NOT NULL
ORDER BY
    life_expectancy ASC;


-- 問17
-- 平均寿命が長い順に国名を表示させてください。ただしNULLは表示させないでください。
SELECT NAME
    ,
    life_expectancy
FROM
    `countries`
WHERE
    life_expectancy IS NOT NULL
ORDER BY
    life_expectancy DESC;


-- 問18
-- 平均寿命が長い順、独立記念日が新しい順に国を表示させてください。
SELECT NAME
    ,
    life_expectancy,
    indep_year
FROM
    `countries`
ORDER BY
    life_expectancy
DESC
    ,
    indep_year ASC;


-- 問19
-- 全ての国の国コードの一文字目と国名を表示させてください。
SELECT
    SUBSTRING(CODE, 1, 1),
    NAME
FROM
    `countries`;


-- 問20
-- 国名が長いものから順に国名と国名の長さを出力してください。
SELECT NAME
    ,
    LENGTH(NAME)
FROM
    `countries`
ORDER BY
    LENGTH(NAME)
DESC
    ;


-- 問21
-- 全ての地方の平均寿命、平均人口を表示してください。(NULLも表示)
SELECT
    region,
    life_expectancy AS '平均寿命',
    AVG(population) AS '平均人口'
FROM
    `countries`
GROUP BY
    region;


-- 問22
-- 全ての地方の最長寿命、最大人口を表示してください。(NULLも表示)
SELECT
    region,
    MAX(life_expectancy) AS '最大寿命',
    MAX(population) AS '最大人口'
FROM
    `countries`
GROUP BY
    region;



-- 問23
-- アジア大陸の中で最小の表面積を表示してください
SELECT
    MIN(surface_area) AS 'アジアの最小表面積',
    continent
FROM
    `countries`
WHERE
    continent = 'Asia';

-- 問24
-- アジア大陸の表面積の合計を表示してください。
SELECT
    SUM(surface_area) AS 'アジア大陸の表面積の合計',
    continent
FROM
    `countries`
WHERE
    continent = 'Asia';

-- 問25
-- 全ての国と言語を表示してください。
SELECT
    countries.name,
    countrylanguages.language
FROM
    `countries`
JOIN `countrylanguages` ON countries.code = countrylanguages.country_code;


-- 問26
-- 全ての国と言語と市区町村を表示してください。
SELECT
    countries.name,
    cities.district,
    countrylanguages.language
FROM
    `countries`
JOIN `cities` ON countries.code = cities.country_code
LEFT JOIN `countrylanguages` ON countries.code = countrylanguages.country_code;


-- 問27
-- 全ての有名人を出力してください。左側外部結合を使用して国名なし（country_codeがNULL）も表示してください。
SELECT
    celebrities.name,
    countries.name
FROM
    `celebrities`
LEFT JOIN `countries` ON celebrities.country_code = countries.code;

-- 問28
-- 全ての有名人の名前,国名、第一言語を出力してください。
SELECT
    celebrities.name,
    countries.name,
    countrylanguages.language
FROM
    `celebrities`
JOIN `countries` ON celebrities.country_code = countries.code
LEFT JOIN `countrylanguages` ON celebrities.country_code = countrylanguages.country_code
WHERE
    countrylanguages.is_official = TRUE;


-- 問29
-- 全ての有名人の名前と国名をテーブル結合せずに出力してください。
SELECT
    celebrities.name,
    countries.name
FROM
    `celebrities`,
    `countries`
WHERE
    celebrities.country_code = countries.code;

-- 問30
-- 最年長が50歳以上かつ最年少が30歳以下の国を表示させてください。
SELECT
    country_code,
    MAX(age) AS 'MAX(ce.age)',
    MIN(age) AS 'MIN(ce.age)'
FROM
    `celebrities`
WHERE
    country_code != ""
GROUP BY
    country_code
HAVING
    MAX(age) > 50 AND MIN(age) < 30;


-- 問31
-- 1991年生まれと、1981年生まれの有名人が何人いるか調べてください。ただし、日付関数は使用せず、UNION句を使用してください。
SELECT
    1991 AS '誕生年',
    COUNT(birth) AS '人数'
FROM
    `celebrities`
GROUP BY birth
UNION
SELECT
    1981 AS '誕生年',
    COUNT(birth) AS '人数'
FROM
    `celebrities`
GROUP BY birth;



-- 問32
-- 有名人の出身国の平均年齢を高い方から順に表示してください。ただし、FROM句はcountriesテーブルとしてください。
SELECT
    countries.name AS '国名',
    AVG(celebrities.age) AS '平均年齢'
FROM
    `countries`
RIGHT JOIN `celebrities` ON countries.code = celebrities.country_code
WHERE
    countries.name IS NOT NULL
GROUP BY
    countries.name
ORDER BY
    `平均年齢`
DESC
    



































