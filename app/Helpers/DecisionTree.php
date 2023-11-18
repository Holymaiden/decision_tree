<?php

namespace App\Helpers;

use App\Models\Drug;

use function PHPSTORM_META\map;

class DecisionTree
{
    // private $tree;
    private $tree = [
        "bebas" => [
            "tetes telinga" => ["vital"],
            "demam" => ["panadol", "grafudor", "novagesic"],
            "sakit kepala" => ["paramex"],
            "maag" => ["polysisilane", "Mylanta"],
            "diare" => ["entrostop"],
            "penambah darah" => ["folavit"],
            "demam anak" => ["inzana"],
            "sakit tenggorokan" => ["cooling 5"],
            "demam dan nyeri" => ["sanmol"],
            "asam lambung" => ["promag"],
        ],
        "bebas terbatas" => [
            "Flu" => ["Demacolin"],
            "pelancar bab" => ["dulcolax"],
            "cacing" => ["combantrin"],
            "asma" => ["neo napacin"],
            "nyeri haid" => ["feminax"],
            "tetes mata" => ["braito"],
            "obat kutu" => ["peditox"],
            "pilek" => ["alerhis"],
            "kumur" => ["betadine mounwash"],
            "batuk & flu" => ["dekolsin"],
            "mual perjalanan" => ["antimo"],
            "batuk berdahak" => ["paratusin"],
            "demam & nyeri" => ["farsifan plus", "bufect"],
        ],
        "keras" => [
            "alergi" => ["histapan"],
            "antibiotik" => ["amoxsan"],
            "asma" => ["lasal"],
            "sakit perut" => ["promuba"],
            "radang kulit" => ["hydrocortisone"],
            "nyeri otot" => ["neuralgin"],
            "diare" => ["sukralfat"],
            "batuk berdahak" => ["efexol", "lasal ekspektoran"],
            "radang" => ["predrisone"],
            "mual" => ["demperidone"],
            "maag" => ["propeps"],
            "mual & muntah" => ["damaben"],
        ],
        "wajib apotek" => [
            "asma" => ["acetylcysteine", "salbutamol"],
            "alergi" => ["ctm"],
            "sariawan" => ["nymiko"],
            "radang" => ["betametasone", "prednisone"],
            "demam" => ["asam mefenamat"],
            "jamur" => ["metyilprednisone"],
            "asam lambung" => ["omeprozol"],
            "bakteri" => ["gentamicin"],
            "diare" => ["secralfate"],
        ],
        "psikotropika" => [
            "insomnia" => ["dumolit"],
            "penenang" => ["calmet", "xanax", "lexotan"],
            "pengobatan kecemasan" => ["valium"],
        ],
        "narkotika" => [
            "meredahkan batuk" => ["kodein"],
            "nyeri kanker & serangan jantung" => ["morfin"],
            "nyeri persalinan" => ["petadin"],
            "peredah nyeri" => ["oksidon"],
            "meredahkan ketergantungan" => ["metadon"],
        ],
    ];


    function __construct()
    {
        $data = Drug::all();

        // filter data to category -> type -> name
        $tree = array();
        foreach ($data as $key => $value) {
            if (!array_key_exists($value->category, $tree)) {
                $tree[$value->category] = array();
            }
            if (!array_key_exists($value->type, $tree[$value->category])) {
                $tree[$value->category][$value->type] = array();
            }
            array_push($tree[$value->category][$value->type], $value->name);
        }

        $this->tree = $tree;
    }

    public function getDrug($category, $disease)
    {
        if (!array_key_exists($category, $this->tree)) {
            return "Invalid drug category";
        }


        $subtree = $this->tree[$category];
        if (!array_key_exists($disease, $subtree)) {
            $subtree[$disease] = array();
            $tree = $this->getTree();
            foreach ($tree as $key => $value) {
                if (array_key_exists($disease, $value)) {
                    array_push($subtree[$disease], $value);
                }
            }
        }

        $medicines = $subtree[$disease];

        if (!is_array($medicines)) {
            return $medicines;
        }


        $new_medicines = array();
        for ($i = 0; $i < count($medicines); $i++) {
            // push medicine disease
            if (is_array($medicines[$i])) {
                if (array_key_exists($disease, $medicines[$i])) {
                    for ($j = 0; $j < count($medicines[$i][$disease]); $j++)
                        array_push($new_medicines, $medicines[$i][$disease][$j]);
                }
            } else
                array_push($new_medicines, $medicines[$i]);
        }

        return $new_medicines;
    }

    public function getHighestGainCategory()
    {
        $categories = array_keys($this->tree);
        $max_gain = 0;
        $max_category = "";

        // Calculate initial entropy
        $total_count = 0;
        $class_counts = array();
        foreach ($this->tree as $category => $subtree) {
            foreach ($subtree as $disease => $drug) {
                for ($i = 0; $i < count($drug); $i++) {
                    $total_count++;
                    if (isset($class_counts[$category . "-" . $disease])) {
                        $class_counts[$category . "-" . $disease]++;
                    } else {
                        $class_counts[$category . "-" . $disease] = 1;
                    }
                }
            }
        }
        $initial_entropy = $this->calculateEntropy($class_counts, $total_count);

        // Calculate information gain for each category
        foreach ($categories as $category) {
            $subtree = $this->tree[$category];
            $count = 0;
            $class_counts = array();
            foreach ($subtree as $disease => $drug) {
                for ($i = 0; $i < count($drug); $i++) {
                    $count++;
                    if (isset($class_counts[$category . "-" . $disease])) {
                        $class_counts[$category . "-" . $disease]++;
                    } else {
                        $class_counts[$category . "-" . $disease] = 1;
                    }
                }
            }
            $entropy = $this->calculateEntropy($class_counts, $count);
            $gain = $initial_entropy - ($count / $total_count) * $entropy;
            if ($gain > $max_gain) {
                $max_gain = $gain;
                $max_category = $category;
            }
        }

        return $max_category;
    }

    private function calculateEntropy($class_counts, $total_count)
    {
        $entropy = 0;
        foreach ($class_counts as $count) {
            $p = $count / $total_count;
            $entropy -= $p * log($p, 2);
        }
        return $entropy;
    }

    public function getDrugByDisease($disease)
    {
        $max_category = $this->getHighestGainCategory();

        if ($max_category == '') {
            return "Invalid disease input";
        }

        return $this->getDrug($max_category, $disease);
    }

    public function getSubtree($category)
    {
        if (!array_key_exists($category, $this->tree)) {
            return "Invalid drug category";
        }

        return $this->tree[$category];
    }

    public function getTree()
    {
        return $this->tree;
    }

    public function setTree($tree)
    {
        $this->tree = $tree;
    }
}
