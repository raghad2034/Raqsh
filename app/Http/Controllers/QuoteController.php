<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quote;
use App\Models\Like;
use App\Models\Bookmark;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with(['user', 'likes', 'bookmarks'])->latest()->get();

        $masters = [
            [
                'id' => 1,
                'name' => 'الأمير بدر بن عبد المحسن',
                'years' => 'شاعر ورسام · ١٩٤٩ - ٢٠٢٤',
                'title' => 'مهندس الكلمة',
                'tag' => 'شاعر وبدر الحرف',
                'quote' => 'مَا بَقَالِي قَلْب يَشْفَعْ لَكْ خَطِيَّة ... ذَوَّبَتْه جْرُوح صَدِّك وَالْخَطَايَا',
                'story' => 'بدأ الشعر في السادسة عشرة، فصارت كلماته أغاني يحفظها الخليج والعالم العربي كله، ثم أمسك الريشة ورسم الكلمة بالألوان، تاركاً أثراً وجدانياً لا يُمحى.',
                'image' => asset('images/masters/badr.jpg'),
                'lang' => 'ar',
            ],
            [
                'id' => 2,
                'name' => 'فينسنت فان جوخ',
                'years' => 'رسام · ١٨٥٣ - ١٨٩٠',
                'title' => 'الرجل الذي رسم النجوم من خلف القضبان',
                'tag' => 'عبقرية الفرشاة',
                'quote' => 'I dream my painting and I paint my dream',
                'story' => 'لوحة واحدة.. هذا كل ما باعه في حياته بفرنسا ومات فقيراً وحيداً، واليوم تقف الملايين في طوابير طويلة حول العالم لمجرد النظر إلى لوحاته التي تُباع بمئات الملايين.',
                'image' => asset('images/masters/gogh.jpg'),
                'lang' => 'en',
            ],
            [
                'id' => 3,
                'name' => 'أبو الطيب المتنبي',
                'years' => 'شاعر الحكمة · ٩١٥ - ٩٦٥ م',
                'title' => 'مالئ الدنيا وشاغل الناس',
                'tag' => 'مالك زمام القريض',
                'quote' => 'وَمَا الدَّهْرُ إِلَّا مِنْ رُوَاةِ قَلائِدِي ... إِذَا قُلْتُ شِعْراً أَصْبَحَ الدَّهْرُ مُنْشِدَا',
                'story' => 'عاش يبحث عن المجد بالسيف والقلم، وقارع ملوك عصره بحروفه حتى قيل إنه مات مقتولاً بسبب بيتٍ من شعره أصرّ على الثبات لأجله، ليبقى ديوانه أعظم ما نطق به لسان العرب.',
                'image' => asset('images/masters/mutanabbi.png'),
                'lang' => 'ar',
            ],
            [
                'id' => 4,
                'name' => 'فريدا كاهلو',
                'years' => 'رسامة · ١٩٠٧ - ١٩٥٤',
                'title' => 'المرأة التي رسمت ألمها فصار جمالاً',
                'tag' => 'سيدة اللوحات الجريئة',
                'quote' => "Feet, what do I need them for if I have wings to fly",
                'story' => 'حطّم حادث سير مروّع جسدها وهي في ريعان شبابها، فرسمت وهي طريحة الفراش عبر مرآة في السقف، وحضرت معرضها الفني الأول في المكسيك وهي محمولة على سريرها الطبي متحديةً الألم بالألوان.',
                'image' => asset('images/masters/kahlo.jpg'),
                'lang' => 'en',
            ],
            [
                'id' => 5,
                'name' => 'محمود درويش',
                'years' => 'شاعر · ١٩٤١ - ٢٠٠٨',
                'title' => 'عاشق الأرض والرمزية الإنسانية',
                'tag' => 'أيقونة الشعر المعاصر',
                'quote' => 'عَلَى هَذِهِ الأَرْضِ مَا يَسْتَحِقُّ الحَيَاةْ: تَرَدُّدُ إِبْرِيلَ، رَائِحَةُ الخُبْزِ فِي الفَجْرِ، آرَاءُ امْرَأَةٍ فِي الرِّجَالِ، كِتَابَاتُ إِسْخِيلُوسَ، أَوَّلُ الحُبِّ، عُشْبٌ عَلَى حَجَرٍ، أُمَّهَاتٌ تَقِفْنَ عَلَى خَيْطِ نَايٍ، وَخَوْفُ الغُزَاةِ مِنَ الذِّكْرَيَاتْ',
                'story' => 'صاغ هوية شعب وحوّل القصيدة من مجرد رثاء سياسي إلى ملحمة وجودية تتغنى بجمال الحياة والتفاصيل البسيطة التي تستحق أن تُعاش رغم الحصار والمنفى.',
                'image' => asset('images/masters/darwish.jpg'),
                'lang' => 'ar',
            ],
            [
                'id' => 6,
                'name' => 'فرانز كافكا',
                'years' => 'أديب · ١٨٨٣ - ١٩٢٤',
                'title' => 'سابر أغوار القلق الإنساني',
                'tag' => 'فيلسوف القلق الإنساني',
                'quote' => 'A book must be the axe for the frozen sea within us',
                'story' => 'موظف تأمينات انطوائي عاش صراعاً طويلاً مع واقعه، أوصى صديقه المقرب بحرق كل كتاباته بعد موته، لكن الصديق خان الوصية ونشرها لتصبح أعماله حجر زاوية في أدب القرن العشرين.',
                'image' => asset('images/masters/kafka.jpg'),
                'lang' => 'en',
            ],
            [
                'id' => 7,
                'name' => 'جبران خليل جبران',
                'years' => 'أديب وفنان · ١٨٨٣ - ١٩٣١',
                'title' => 'رسول المحبة وفيلسوف الروح',
                'tag' => 'أديب الأجنحة المتكسرة',
                'quote' => 'You are blind and I am deaf and dumb, so let us touch hands and understand',
                'story' => 'هاجر من جبال لبنان فقيراً، ليغزو أمريكا والعالم بكتابه «النبي» الذي أصبح من أكثر الكتب مبيعاً وتُرجم لأكثر من 100 لغة، جامعاً بين رقة الصوفي وفلسفة الفنان التشكيلي.',
                'image' => asset('images/masters/gibran.jpg'),
                'lang' => 'en',
            ],
            [
                'id' => 8,
                'name' => 'فريدريش نيتشه',
                'years' => 'فيلسوف · ١٨٤٤ - ١٩٠٠',
                'title' => 'صاحب المطرقة الفلسفية',
                'tag' => 'فيلسوف الإرادة والوجود',
                'quote' => 'Without music, life would be a mistake',
                'story' => 'أستاذ الفيلولوجيا الشاب الذي زلزل الفكر الغربي بأكمله، عاش سنواته الأخيرة في عزلة متنقلاً بين جبال سويسرا وإيطاليا، يكتب شذراته الفلسفية دفاعاً عن إرادة الحياة وعشق الفنون.',
                'image' => asset('images/masters/nietzsche.jpg'),
                'lang' => 'en',
            ],
        ];

        $savedQuoteIds = [];
        if (Auth::check()) {
            $savedQuoteIds = Bookmark::where('user_id', Auth::id())->pluck('quote_id')->toArray();
        }

        return view('welcome', compact('quotes', 'masters', 'savedQuoteIds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:500',
            'author'  => 'nullable|string|min:2|max:50',
        ], [
            'content.required' => 'حقل الاقتباس لا يمكن أن يكون فارغاً.',
            'content.min'      => 'يجب ألا يقل نص الاقتباس عن 3 أحرف.',
            'content.max'      => 'يجب ألا يتجاوز نص الاقتباس 500 حرف.',
            'author.min'       => 'اسم القائل يجب أن يكون حرفين على الأقل.',
            'author.max'       => 'اسم القائل يجب ألا يتجاوز 50 حرفاً.',
        ]);

        Quote::create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'author'  => $validated['author'] ?: Auth::user()->name,
        ]);

        return back()->with('success', 'أُضيف أثرك بنقاء إلى المنصة.');
    }


    public function update(Request $request, Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:500',
            'author'  => 'nullable|string|min:2|max:50',
        ], [
            'content.required' => 'حقل الاقتباس لا يمكن أن يكون فارغاً.',
            'content.min'      => 'يجب ألا يقل نص الاقتباس عن 3 أحرف.',
            'content.max'      => 'يجب ألا يتجاوز نص الاقتباس 500 حرف.',
            'author.min'       => 'اسم القائل يجب أن يكون حرفين على الأقل.',
            'author.max'       => 'اسم القائل يجب ألا يتجاوز 50 حرفاً.',
        ]);

        $quote->update([
            'content' => $validated['content'],
            'author'  => $validated['author'] ?: Auth::user()->name,
        ]);

        return back()->with('success', 'تم تحديث أثرك بنجاح.');
    }
    
    public function destroy(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) {
            abort(403);
        }
        $quote->delete();
        return back()->with('success', 'تم محو الأثر بنجاح.');
    }

    public function toggleLike(Quote $quote)
    {
        $like = Like::where('user_id', Auth::id())->where('quote_id', $quote->id)->first();
        if ($like) {
            $like->delete();
        } else {
            Like::create(['user_id' => Auth::id(), 'quote_id' => $quote->id]);
        }
        return back();
    }

    public function toggleBookmark(Quote $quote)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->where('quote_id', $quote->id)->first();
        if ($bookmark) {
            $bookmark->delete();
            return back()->with('status', 'أُزيل الأثر من خزانتك.');
        } else {
            Bookmark::create(['user_id' => Auth::id(), 'quote_id' => $quote->id]);
            return back()->with('status', 'حُفظ الأثر في خزانتك الخاصة.');
        }
    }
}